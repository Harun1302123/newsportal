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
use App\Modules\ManualDataEntry\Models\MefBenchmarkRecord;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\ManualDataEntry\Http\Requests\StoreMefBenchmarkRecord;


class MefBenchmarkRecordController extends Controller
{

    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 66;
        $this->list_route = 'mef_benchmark_record.list';
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
                $list = MefBenchmarkRecord::query()
                    ->with(
                        'user','mefBenchmark:id,name','mefProcessStatus:id,status_name,color'
                        )
                    ->orderByDesc('id')
                    ->get();
                
                return Datatables::of($list)
                        ->editColumn('mef_benchmark_id', function ($row) {
                            return $row->mefBenchmark->name;
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
                        $view_btn = '<a href="' . route('mef_benchmark_record.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
                        $edit_btn = '<a href="' . route('mef_benchmark_record.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Edit </a><br>';
                        if ($row->mef_process_status_id == 1) {
                            $edit_btn = '';
                        }
                        return $view_btn . $edit_btn;
                    })
                    ->rawColumns(['action','mef_process_status_id'])
                    ->make(true);
            }

            return view('ManualDataEntry::mef_benchmark_record.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
            ]);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBenchmarkRecordController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefBenchmarkRecord-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        $data['card_title'] = 'Create New';
        $data['list_route'] = $this->list_route;
        return view('ManualDataEntry::mef_benchmark_record.create', $data);
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefBenchmarkRecord $request): RedirectResponse
    {
        
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $isExist = MefBenchmarkRecord::query()->where('year', $request->year)->where('mef_benchmark_id', $request->benchmark)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and benchmark!");
                return redirect()->route($this->list_route);
            }
            if ($isExist && $isExist->mef_process_status_id == 1) {
                Session::flash('error', "Data already submitted!");
                return redirect()->route($this->list_route);
            }
            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $master_data = MefBenchmarkRecord::findOrFail($master_id);
            } else {
                $master_data = new MefBenchmarkRecord();
            }
            $master_data->year = $request->year ?? null;
            $master_data->mef_benchmark_id = $request->benchmark ?? null;
            $master_data->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $master_data->mef_process_status_id = 1; // Submitted
            }
            if ($master_data->mef_benchmark_id) {
                $benchmarkInfo = benchmarkInfo($master_data->mef_benchmark_id);
                $master_data->quarter_ids = $benchmarkInfo->quarter ?? null;
            }
            $master_data->indicator_set_a = $request->indicator_set_a ?? null;
            $master_data->without_goal_12 = $request->without_goal_12 ?? null;
            $master_data->goal_12 = $request->goal_12 ?? null;
            $master_data->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefBenchmarkRecordController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefBenchmarkRecord-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['master_data'] = MefBenchmarkRecord::query()->with('mefBenchmark:id,name')->findOrFail($decode_id);
            return view('ManualDataEntry::mef_benchmark_record.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBenchmarkRecordController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data view [MefBenchmarkRecord-103]");
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
            $data['master_data'] = MefBenchmarkRecord::query()->findOrFail($decode_id);
            $data['card_title'] = 'Edit Data';
            $data['list_route'] = $this->list_route;
            $data['id'] = $id;
            if ($data['master_data']->mef_process_status_id == 1) {
                Session::flash('error', "Data already submitted!");
                return redirect()->route($this->list_route);
            }
            return view('ManualDataEntry::mef_benchmark_record.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBenchmarkRecordController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefBenchmarkRecord-104]");
            return redirect()->back();
        }
    }

}
