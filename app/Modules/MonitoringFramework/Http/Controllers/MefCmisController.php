<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefCmisMasterRequest;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisLabel;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisMaster;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisTable;
use App\Modules\MonitoringFramework\Services\CmisService;
use App\Modules\MonitoringFramework\Services\ExcelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class MefCmisController extends Controller
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
        $this->service_id = 55;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'cmis.list';
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
                return mefDatatableList(new MefCmisMaster(), 'cmis', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'CMIs Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('cmis.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('cmis.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }

            return view('MonitoringFramework::mef_list', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefcmisController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefCmisMaster-101]");
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
            $data['card_title'] = 'Data Entry Form (CMIs)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            $data['divisions'] = getDivisions();

            $tables = MefCmisTable::query()->get();
            if (count($tables->toArray())) {
                foreach ($tables as $value) {
                    $data[$value->table_name] = $this->cmisTableWiseLabels($value->id);
                }
            }
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/CMIs.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::cmis.create', $data);


        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefCmisController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefCmisController-102]");
            return Redirect::back()->withInput();
        }
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefCmisMasterRequest $request, CmisService $cmisService)
    {

        try {

            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            $cmisService->store($request);

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefCmisMaster-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['master_data'] = MefCmisMaster::query()
                ->with('mefCmisDetailsTable1', 'mefCmisDetailsTable2', 'mefCmisDetailsTable3', 'mefCmisDetailsTable4', 'mefCmisDetailsTable8')
                ->findOrFail($decode_id);
            $data['approve_btn'] = '<a href="' . route('cmis.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            $data['check_btn'] = '<a href="' . route('cmis.check', ['id' => $id]) . '" class="btn btn-flat btn-success btn-xs m-1"> Check </a>';
            $data['excel_btn'] = '<a href="' . route('cmis.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/CMIs.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::cmis.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefcmisController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            // ob@16 update error message with method name
            Session::flash('error', "Something went wrong during application data view [MefCmisMaster-103]");
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
            if (!($this->edit_permission)) {
                Session::flash('error', "Don't have edit permission");
                return redirect()->route($this->list_route);
            }

            $decode_id = Encryption::decodeId($id);
            $data['data'] = MefCmisMaster::with(['MefCmisDetailsTable1.division', 'MefCmisDetailsTable2', 'MefCmisDetailsTable3', 'MefCmisDetailsTable4', 'MefCmisDetailsTable8'])->where('id', $decode_id)->first();
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit CMIs';
            $data['list_route'] = $this->list_route;
            if (!($data['data']->mef_process_status_id == '-1' || $data['data']->mef_process_status_id == 5)) {
                Session::flash('error', "This data status is not editable");
                return redirect()->route($this->list_route);
            }

            return view('MonitoringFramework::cmis.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefcmisController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefCmisMaster-104]");
            return redirect()->back();
        }
    }


    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_cmis_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('cmis.summary_report_data');
            $data['card_title'] = 'Cmis Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request, CmisService $cmisservice)
    {
        try {
            $data = $cmisservice->summaryReport($request);
            $data['list_route'] = $this->list_route;
            return view('MonitoringFramework::cmis.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@summary_report ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-105]");
            return redirect()->back();
        }
    }


    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefCmisMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefCmisTable::query()->get();
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
            Log::error("Error occurred in MefCmisController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefCmisMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-108]");
            return redirect()->back();
        }
    }

    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefCmisMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-109]");
            return false;
        }
    }

    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefCmisMaster::query()
                ->with('mefCmisDetailsTable1', 'mefCmisDetailsTable2', 'mefCmisDetailsTable3', 'mefCmisDetailsTable4', 'mefCmisDetailsTable8')
                ->findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'cmis';

            return Excel::download(
                new ExcelService($master_data),
                'cmis_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCmisController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request, CmisService $cmisservice)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $cmisservice->summaryReport($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'cmis';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'cmis_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }


    public static function cmisTableWiseLabels($mef_cmis_table_id)
    {
        return MefcmisLabel::query()->where('mef_cmis_table_id', $mef_cmis_table_id)->orderBy('order')->get();
    }


}
