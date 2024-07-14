<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefCooperativesMasterRequest;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesMaster;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesTable;
use App\Modules\MonitoringFramework\Services\CooperativesService;
use App\Modules\MonitoringFramework\Services\ExcelService;
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

class MefCooperativesController extends Controller
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
        $this->service_id = 53;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'cooperatives.list';
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
                return mefDatatableList(new MefCooperativesMaster(), 'cooperatives', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'Cooperatives Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('cooperatives.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('cooperatives.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }

            return view('MonitoringFramework::mef_list', $data);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefCooperativesMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            if (!($this->add_permission)) {
                Session::flash('error', "Don't have create permission");
                return redirect()->route($this->list_route);
            }

            $data['card_title'] = 'Data Entry Form (Cooperatives)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            $data['divisions'] = getDivisions();

            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Cooperatives.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';


            // ob@3 this data is unused, check and remove
            return view('MonitoringFramework::cooperatives.create', $data);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativeMaster-102]");
            return redirect()->back();
        }
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefCooperativesMasterRequest $request, CooperativesService $cooperativeservice)
    {

        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            $cooperativeservice->store($request);

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefCooperativesController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefCooperativesMaster-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = MefCooperativesMaster::query()
                ->with('mefCooperativesDetailsTable1', 'mefCooperativesDetailsTable2', 'mefCooperativesDetailsTable3', 'mefCooperativesDetailsTable4', 'mefCooperativesDetailsTable5', 'mefCooperativesDetailsTable8')
                ->findOrFail($decode_id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['approve_btn'] = '<a href="' . route('cooperatives.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            $data['check_btn'] = '<a href="' . route('cooperatives.check', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Check </a>';
            $data['excel_btn'] = '<a href="' . route('cooperatives.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Cooperatives.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';



            return view('MonitoringFramework::cooperatives.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data view [MefCooperativesMaster-103]");
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
                $data['data'] = MefCooperativesMaster::with(['mefCooperativesDetailsTable1.division'])->where('id', $decode_id)->first();
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Cooperatives';
                $data['list_route'] = $this->list_route;
                $data['divisions'] = getDivisions();

                if (!($data['data']->mef_process_status_id == '-1' || $data['data']->mef_process_status_id == 5)) {
                    Session::flash('error', "This data status is not editable");
                    return redirect()->route($this->list_route);
                }

                return view('MonitoringFramework::cooperatives.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            // ob@21 update error message code
            Session::flash('error', "Something went wrong during application data edit [MefCooperativesMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_cooperatives_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('cooperatives.summary_report_data');
            $data['card_title'] = 'Cooperatives Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativesMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request, CooperativesService $cooperativeservice)
    {
        try {
            $data = $cooperativeservice->summaryReport($request);
            $data['list_route'] = $this->list_route;
            // ob@17 incomplete summaryReport, follow MefMfisController@summaryReport
            return view('MonitoringFramework::cooperatives.summary_report', $data);
        } catch (\Exception $e) {
            // ob@18 update MefMfisController@edit, MefMfisMaster-103
            Log::error("Error occurred in MefCooperivesController@summary_report ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            // ob@19 update error message with method name and code
            Session::flash('error', "Something went wrong [MefMfisMaster-106]");
            return redirect()->back();
        }
    }


    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefCooperativesMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefCooperativesTable::query()->get();
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
            Log::error("Error occurred in MefCooperativesController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativesMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefCooperativesMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativesMaster-108]");
            return redirect()->back();
        }
    }

    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefCooperativesMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativesMaster-109]");
            return false;
        }
    }


    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefCooperativesMaster::query()
                ->with('mefCooperativesDetailsTable1', 'mefCooperativesDetailsTable2', 'mefCooperativesDetailsTable3', 'mefCooperativesDetailsTable4', 'mefCooperativesDetailsTable5', 'mefCooperativesDetailsTable8')
                ->findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'cooperatives';

            return Excel::download(
                new ExcelService($master_data),
                'cooperatives_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefCooperativesController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCooperativesMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request, CooperativesService $cooperativeservice)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $cooperativeservice->summaryReport($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'cooperatives';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'cooperatives_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }


}
