<?php

namespace App\Modules\ManualDataEntry\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\ACL;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\ManualDataEntry\Http\Requests\StoreMefSetwiseDataRequest;
use App\Modules\ManualDataEntry\Models\MefSetManualDataMasterRecord;
use App\Modules\ManualDataEntry\Models\MefSetManualDataDetailsRecord;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MefSetwiselDataController extends Controller
{

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 62;
        $this->list_route = 'mef_setwise_data.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = MefSetManualDataMasterRecord::query()
                    ->with(
                        'user','mefQuarter:id,name','mefProcessStatus:id,status_name,color'
                    )
                    ->orderByDesc('id')             
                    ->get();

                return Datatables::of($list)
                    ->editColumn('mef_quarter_id', function ($row) {
                        return $row->mefQuarter->name;
                    })
                    ->editColumn('mef_process_status_id', function ($row) {
                        return  '<span class="badge text-white" style="background-color: '.$row->mefProcessStatus->color.' " >'.$row->mefProcessStatus->status_name.'</span>';
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->username;
                    })
                    ->addColumn('action', function ($row) {
                        $view_btn = '<a href="' . route('mef_setwise_data.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
                        $edit_btn = '<a href="' . route('mef_setwise_data.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Edit </a><br>';
                        if ($row->mef_process_status_id == 1) {
                            $edit_btn = '';
                        }
                        return $view_btn . $edit_btn;
                    })
                    ->rawColumns(['action','mef_process_status_id'])
                    ->make(true);
            }

            return view('ManualDataEntry::mef_setwise_data.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefSetwiselDataController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefSetwiseData-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        $data['card_title'] = 'Create New Setwise Data';
        $data['list_route'] = $this->list_route;
        $data['mef_sets'] = mefSets();
        return view('ManualDataEntry::mef_setwise_data.create', $data);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefSetwiseDataRequest $request): RedirectResponse
    {

        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $isExist = MefSetManualDataMasterRecord::query()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->route($this->list_route);
            }
            if ($isExist && $isExist->mef_process_status_id == 1) {
                Session::flash('error', "Data already submitted!");
                return redirect()->route($this->list_route);
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefSetwiseData = MefSetManualDataMasterRecord::findOrFail($master_id);
            } else {
                $mefSetwiseData = new MefSetManualDataMasterRecord();
            }
            $mefSetwiseData->year = $request->year ?? null;
            $mefSetwiseData->mef_quarter_id = $request->quarter ?? null;
            $mefSetwiseData->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefSetwiseData->mef_process_status_id = 1; // Submitted
            }
            $mefSetwiseData->save();

            foreach ($request->set_id as $key => $item) {
                $detailsTableId = $request->mef_setwise_data_details_id[$key] ?? null;
                $table1 = MefSetManualDataDetailsRecord::findOrNew($detailsTableId);
                $table1->master_id = $mefSetwiseData->id;
                $table1->set_id = $item ?? null;
                if ($key == 0) {
                    $setWiseInfo = [
                        "set_a_total_population" => $request->set_a_total_population ?? null,
                        "allocated_score" => $request->allocated_score[$key] ?? null,
                        "maximum_score" => $request->maximum_score[$key] ?? null,
                    ];
                }else{
                    $setWiseInfo = [
                        "allocated_score" => $request->allocated_score[$key] ?? null,
                        "maximum_score" => $request->maximum_score[$key] ?? null,
                    ];
                }
                $table1->set_info = json_encode($setWiseInfo);

                if ($request->actionBtn == 'submit') {
                    $table1->mef_quarter_id = $request->quarter;
                    $table1->year = $request->year;
                    $table1->is_approved = 1;
                }

                $table1->save();
            }

            DB::commit();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefSetwiselDataController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefSetwiseData-102]");
            return Redirect::back()->withEntry();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['master_data'] = MefSetManualDataMasterRecord::query()->with('mefSetManualDataDetailsRecord')->findOrFail($decode_id);
            return view('ManualDataEntry::mef_setwise_data.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefSetwiselDataController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefSetwiseData-103]");
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = MefSetManualDataMasterRecord::query()->with('mefSetManualDataDetailsRecord')->findOrFail($decode_id);
            $data['card_title'] = 'Edit Setwise Data';
            $data['list_route'] = $this->list_route;
            $data['id'] = $id;
            if ($data['master_data']->mef_process_status_id == 1) {
                Session::flash('error', "Data already submitted!");
                return redirect()->route($this->list_route);
            }
            return view('ManualDataEntry::mef_setwise_data.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefSetwiselDataController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefSetwiseData-103]");
            return redirect()->back();
        }
    }
}
