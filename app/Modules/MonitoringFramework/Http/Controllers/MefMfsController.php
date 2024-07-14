<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefMfsMasterRequest;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsLabel;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsMaster;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsTable;
use App\Modules\MonitoringFramework\Services\ExcelService;
use App\Modules\MonitoringFramework\Services\MfsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class MefMfsController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;
    protected int $provide;
    protected int $approve;
    protected int $checker;

    public function __construct()
    {
        $this->service_id = 50;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'mfs.list';
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
                return mefDatatableList(new MefMfsMaster(), 'mfs', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'MFS Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('mfs.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('mfs.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }

            return view('MonitoringFramework::mef_list', $data);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefMfsMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $data['card_title'] = 'Data Entry Form (MFS)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;

            $tables = MefMfsTable::query()->get();
            if (count($tables->toArray())) {
                foreach ($tables as $value) {
                    $data[$value->table_name] = $this->mfsTableWiseLabels($value->id);
                }
            }
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/MFS.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::mfs.create', $data);

        }
        catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefCmisController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefCmisController-102]");
            return Redirect::back()->withInput();
        }

        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefMfsMasterRequest $request, MfsService $mfsservice)
    {

        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $mfsservice->store($request);

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefMfsController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefMfsMaster-103]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = MefMfsMaster::findOrFail($decode_id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['approve_btn'] = '<a href="' . route('mfs.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            $data['check_btn'] = '<a href="' . route('mfs.check', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Check </a>';
            $data['excel_btn'] = '<a href="' . route('mfs.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';

            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/MFS.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::mfs.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefMfsMaster-104]");
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
            if ($this->edit_permission) {
                $decode_id = Encryption::decodeId($id);
                $data['data'] = MefMfsMaster::findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit MFS';
                $data['list_route'] = $this->list_route;

                if (!($data['data']->mef_process_status_id == '-1' || $data['data']->mef_process_status_id == 5)) {
                    Session::flash('error', "This data status is not editable");
                    return redirect()->route($this->list_route);
                }

                return view('MonitoringFramework::mfs.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefMfsMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_mfs_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('mfs.summary_report_data');
            $data['card_title'] = 'Mfs Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefMfsMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request, MfsService $mfsService)
    {
        try {
            $data = $mfsService->summaryReport($request);
            $data['list_route'] = $this->list_route;
            return view('MonitoringFramework::mfs.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefMfsMaster-106]");
            return redirect()->back();
        }
    }


    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefMfsMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefMfsTable::query()->get();
            if ($tables->count()) {
                foreach ($tables as $value) {
                    approvalUpdateQuery($value->table_name, $master_id, $master_data->mef_quarter_id, $master_data->year);
                }
            }
            DB::commit();

            Session::flash('success', 'Data successfully approved!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefMfsController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefMfsMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefMfsMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefMfsMaster-108]");
            return redirect()->back();
        }
    }


    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefMfsMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefMfsMaster-109]");
            return false;
        }
    }


    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefMfsMaster::findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'mfs';

            return Excel::download(
                new ExcelService($master_data),
                'mfs_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefMfsMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request, MfsService $mfsService)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $mfsService->summaryReport($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'mfs';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'mfs_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }


    public static function mfsTableWiseLabels($mef_mfs_table_id){
        return MefMfsLabel::query()->where('mef_mfs_table_id', $mef_mfs_table_id)->orderBy('order')->get();
    }



}
