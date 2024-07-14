<?php

namespace App\Modules\Goals\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Goals\Models\GoalDetailsRecord;
use App\Modules\Goals\Models\GoalMasterRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\MonitoringFramework\Services\ExcelService;
use Maatwebsite\Excel\Facades\Excel;

class GoalTrackingController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 63;
        $this->list_route = 'goal_trackings.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws \Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = GoalMasterRecord::query()
                ->with(
                    'user', 'mefQuarter:id,name',
                    'mefProcessStatus:id,status_name,color'
                    )
                ->orderByDesc('id')
                ->get();
                return Datatables::of($list)
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->editColumn('mef_quarter_id', function ($row) {
                        return $row->mefQuarter->name;
                    })
                    ->editColumn('mef_process_status_id', function ($row) {
                        return  '<span class="badge text-white" style="background-color: '.$row->mefProcessStatus->color.' " >'.$row->mefProcessStatus->status_name.'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $view_btn = '<a href="' . route('goal_trackings.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
                        $edit_btn = '<a href="' . route('goal_trackings.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Edit </a><br>';
                        return $view_btn;
                    })
                    ->rawColumns(['action', 'mef_process_status_id'])
                    ->make(true);
            }
            return view('Goals::goal_tracking_list', ['add_permission' => $this->add_permission, 'edit_permission' => $this->edit_permission, 'view_permission' => $this->view_permission]);

        } catch (Exception $e) {
            Log::error("Error occurred in GoalTrackingController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Goal-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * @return View|JsonResponse
     */
    public function create(): View|RedirectResponse
    {
        if (!($this->add_permission)) {
            Session::flash('error', "Don't have create permission");
            return redirect()->route($this->list_route);
        }
        $data['card_title'] = 'Create New Goal Tracking';
        $data['list_route'] = $this->list_route;
        $data['add_permission'] = $this->add_permission;
        return view('Goals::create', $data);
    }


    public function goalTrackingForm( Request $request ): View|RedirectResponse
    {
        try {
            $data['quarter'] = $request->quarter ?? null;
            $data['year'] = $request->year ?? null;

            return view('Goals::goal_tracking_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in GoalTrackingController@goalTrackingForm ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Goal-103]");
            return redirect()->back();
        }
    }

    public function publishGoalTrackingData( Request $request )
    {
        try {
            $goalWithout12Info = [
                "totalScoreWithoutGoal12" => $request->totalScoreWithoutGoal12 ?? null,
                "maximumScoreWithoutGoal12" => $request->maximumScoreWithoutGoal12 ?? null,
                "convertedScoreWithoutGoal12" => $request->convertedScoreWithoutGoal12 ?? null,
                "benchmarkWithoutGoal12" => $request->benchmarkWithoutGoal12 ?? null,
                "WeightedScoreWithoutGoal12" => $request->WeightedScoreWithoutGoal12 ?? null,
            ];
            $goal12Info = [
                "totalScoreGoal12" => $request->totalScoreGoal12 ?? null,
                "maximumScoreGoal12" => $request->maximumScoreGoal12 ?? null,
                "convertedScoreGoal12" => $request->convertedScoreGoal12 ?? null,
                "benchmarkGoal12" => $request->benchmarkGoal12 ?? null,
                "WeightedScoreGoal12" => $request->WeightedScoreGoal12 ?? null,

            ];
            $master_id = Encryption::decodeId($request->master_id);
            $goalMaster = GoalMasterRecord::findOrFail($master_id);
            $goalMaster->goal_without12_info = json_encode($goalWithout12Info);
            $goalMaster->goal12_info = json_encode($goal12Info);
            $goalMaster->total_Weighted_score = $request->totalWeightedScore ?? null;
            $goalMaster->mef_process_status_id = 10;	// Published
            $goalMaster->is_approved = 1;	// Approved
            $goalMaster->save();

            Session::flash('success', 'Data publish successfully!');
            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in GoalTrackingController@publishGoalTrackingData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Goal-104]");
            return redirect()->back();
        }
    }

    public function storeGoalTrackingData(Request $request )
    {
        try {
            // also need to check status
            $isExist = GoalMasterRecord::query()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $goalMaster = GoalMasterRecord::findOrFail($master_id);
            } else {
                $goalMaster = new GoalMasterRecord();
            }
            $goalMaster->year = $request->year ?? null;
            $goalMaster->mef_quarter_id = $request->quarter ?? null;
            // $goalMaster->mef_process_status_id = 10;	// Published
            // $goalMaster->is_approved = 1; // Approved
            $goalMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $goalMaster->mef_process_status_id = 1; // Submitted
            }
            $goalMaster->save();

            $i = 0;
            foreach ($request->target_id as $key => $item) {
                if ($request->goal_id[$key] == 12) {
                    $goalWiseInfo = [
                        "goal12_policy_status" => $request->goal12_policy_status[$i] ?? null,
                        "goal12_policy_status_score" => ($request->goal12_policy_status[$i]=='yes'? 1 :-1),
                        "goal12_operational_status" => $request->goal12_operational_status[$i] ?? null,
                        "goal12_operational_status_score" => ($request->goal12_operational_status[$i]=='yes'? 1 :-1),
                        "goal12_inclusive_status" => $request->goal12_inclusive_status[$i] ?? null,
                        "goal12_inclusive_status_score" => ($request->goal12_inclusive_status[$i]=='yes'? 1 :-1),
                    ];
                    $score = ($request->goal12_policy_status[$i]=='yes'? 1 :-1) + ($request->goal12_operational_status[$i]=='yes'? 1 :-1) + ($request->goal12_inclusive_status[$i]=='yes'? 1 :-1);
                    $i ++;
                } else {
                    $implementation_status_score = 0;
                    if ($request->implementation_status[$key] == 'FI') {
                        $implementation_status_score = 1;
                    }elseif ($request->implementation_status[$key] == 'PI') {
                        $implementation_status_score = 0.5;
                    }
                    $goalWiseInfo = [
                        "implementation_status" => $request->implementation_status[$key] ?? null,
                        "implementation_status_score" => $implementation_status_score ?? null,
                    ];
                    $score = $implementation_status_score ?? null;
                }
                $detailsTableId = $request->details_table_id[$key] ?? null;
                $detailsTable = GoalDetailsRecord::findOrNew($detailsTableId);
                $detailsTable->master_id = $goalMaster->id;
                $detailsTable->target_id = $item ?? null;
                $detailsTable->goal_id = $request->goal_id[$key] ?? null;
                $detailsTable->score = $score ?? null;
                $detailsTable->goal_wise_info = json_encode($goalWiseInfo);
                $detailsTable->save();
            }

            DB::commit();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in GoalTrackingController@storeGoalTrackingData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Goal-105]");
            return redirect()->back();
        }
    }

    public function view($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = GoalMasterRecord::query()
                ->with('goalDetailsRecord')
                ->findOrFail($decode_id);

            $data['card_title'] = "Goal Tracking Preview";
            $data['list_route'] = $this->list_route;
            $data['id'] = $id;
            $data['excel_btn'] = '<a href="' . route('goal_trackings.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';

            return view('Goals::goal_tracking_preview', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in GoalTrackingController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Goal-104]");
            return redirect()->back();
        }
    }

    public function excel($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $master_data = GoalMasterRecord::query()
                ->with('goalDetailsRecord')
                ->findOrFail($decode_id);

            $master_data->viewType = 'excel';
            $master_data->scoreType = 'goal_tracking';

            return Excel::download(
                new ExcelService($master_data),
                'goal_tracking.xlsx'
            );

        } catch (\Exception $e) {
            Log::error("Error occurred in GoalTrackingController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [Goal-105]");
            return false;
        }
    }

}
