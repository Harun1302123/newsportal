<?php

namespace App\Modules\ManualDataEntry\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\ACL;
use App\Modules\ManualDataEntry\Http\Requests\StoreMefIndicatorDataRequest;
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
use App\Modules\ManualDataEntry\Models\MefIndicatorManualDataDetailsRecord;
use App\Modules\ManualDataEntry\Models\MefIndicatorManualDataMasterRecord;
use App\Modules\MonitoringFramework\Models\MefIndicator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MefIndicatorDataController extends Controller
{

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 60;
        $this->list_route = 'mef_indicator_data.list';
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request) : View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('post')) {
                $list = MefIndicatorManualDataMasterRecord::query()
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
                        $view_btn = '<a href="' . route('mef_indicator_data.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
                        $edit_btn = '<a href="' . route('mef_indicator_data.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Edit </a><br>';
                        if ($row->mef_process_status_id == 1) {
                            $edit_btn = '';
                        }
                        return $view_btn . $edit_btn;
                    })
                    ->rawColumns(['action','mef_process_status_id'])
                    ->make(true);
            }

            return view('ManualDataEntry::mef_indicator_data.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorDataController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefIndicatorData-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        $data['card_title'] = 'Create New Indicator Data';
        $data['list_route'] = $this->list_route;
        $data['label_name'] = MefIndicator::query()->where('is_nau', 1)->get();
        return view('ManualDataEntry::mef_indicator_data.create', $data);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefIndicatorDataRequest $request): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $isExist = MefIndicatorManualDataMasterRecord::query()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
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
                $mefManualData = MefIndicatorManualDataMasterRecord::findOrFail($master_id);
            } else {
                $mefManualData = new MefIndicatorManualDataMasterRecord();
            }
            $mefManualData->year = $request->year ?? null;
            $mefManualData->mef_quarter_id = $request->quarter ?? null;
            $mefManualData->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefManualData->mef_process_status_id = 1; // Submitted
            }
            $mefManualData->save();

            foreach ($request->indicator_id as $key => $item) {
                $detailsTableId = $request->mef_indicator_data_details_id[$key] ?? null;
                $table1 = MefIndicatorManualDataDetailsRecord::findOrNew($detailsTableId);
                $table1->master_id = $mefManualData->id;
                $table1->indicator_id = $item ?? null;
                $table1->indicator_value = $request->indicator_value[$key] ?? null;
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
            Log::error("Error occurred in MefIndicatorDataController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefIndicatorData-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['master_data'] = MefIndicatorManualDataMasterRecord::query()->with('mefIndicatorManualDataDetailsRecord')->findOrFail($decode_id);
            return view('ManualDataEntry::mef_indicator_data.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorDataController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data view [MefIndicatorData-103]");
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
            $data['master_data'] = MefIndicatorManualDataMasterRecord::query()->with('mefIndicatorManualDataDetailsRecord')->findOrFail($decode_id);
            $data['card_title'] = 'Edit Indicator Data';
            $data['list_route'] = $this->list_route;
            $data['id'] = $id;
            if ($data['master_data']->mef_process_status_id == 1) {
                Session::flash('error', "Data already submitted!");
                return redirect()->route($this->list_route);
            }
            return view('ManualDataEntry::mef_indicator_data.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorDataController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefIndicatorData-104]");
            return redirect()->back();
        }
    }

}
