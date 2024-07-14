<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefInsuranceMasterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceMaster;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceTable;
use App\Modules\MonitoringFramework\Services\ExcelService;
use App\Modules\MonitoringFramework\Services\InsuranceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class MefInsuranceController extends Controller
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
        $this->service_id = 52;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'insurance.list';
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
                return mefDatatableList(new MefInsuranceMaster(), 'insurance', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'Insurance Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('insurance.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('insurance.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }

            return view('MonitoringFramework::mef_list', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefInsuranceMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Data Entry Form (Insurance)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;

            $data['divisions'] = getDivisions();

            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Insurance.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';


            return view('MonitoringFramework::insurance.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefInsuranceMasterRequest $request, InsuranceService $insuranceService): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            // call store service
            $insuranceService->store($request);

            return redirect()->route("$this->list_route");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefInsuranceController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefInsuranceMaster-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['master_data'] = MefInsuranceMaster::query()
                ->with(
                    'mefInsuranceDetailsTable1','mefInsuranceDetailsTable2','mefInsuranceDetailsTable3',
                    'mefInsuranceDetailsTable4','mefInsuranceDetailsTable5', 'mefInsuranceDetailsTable8'
                )
                ->findOrFail($decode_id);
            $data['approve_btn'] = '<a href="' . route('insurance.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            $data['check_btn'] = '<a href="' . route('insurance.check', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Check </a>';
            $data['excel_btn'] = '<a href="' . route('insurance.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Insurance.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::insurance.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefInsuranceMaster-103]");
            return redirect()->back();
        }
    }

    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_insurance_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('insurance.summary_report_data');
            $data['card_title'] = 'Insurance Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request, InsuranceService $insuranceService): View|RedirectResponse
    {
        try {
            // call service function
            $data = $insuranceService->summaryReport($request);
            $data['list_route'] = $this->list_route;
            return view('MonitoringFramework::insurance.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefInsuranceMaster-103]");
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
                $data['master_data'] = MefInsuranceMaster::query()
                    ->with( 'mefInsuranceDetailsTable1','mefInsuranceDetailsTable2','mefInsuranceDetailsTable3','mefInsuranceDetailsTable4',
                        'mefInsuranceDetailsTable5', 'mefInsuranceDetailsTable8'
                    )
                    ->findOrFail($decode_id);
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit Insurance';
                $data['list_route'] = $this->list_route;
                $data['id'] = $id;

                if (!($data['master_data']->mef_process_status_id == '-1' || $data['master_data']->mef_process_status_id == 5)) {
                    Session::flash('error', "This data status is not editable");
                    return redirect()->route($this->list_route);
                }

                return view('MonitoringFramework::insurance.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefInsuranceMaster-103]");
            return redirect()->back();
        }
    }


    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefInsuranceMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefInsuranceTable::query()->get();
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
            Log::error("Error occurred in MefInsuranceController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefInsuranceMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceMaster-108]");
            return redirect()->back();
        }
    }

    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefInsuranceMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceMaster-109]");
            return false;
        }
    }

    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefInsuranceMaster::query()
            ->with(
                'mefInsuranceDetailsTable1','mefInsuranceDetailsTable2','mefInsuranceDetailsTable3',
                'mefInsuranceDetailsTable4','mefInsuranceDetailsTable5', 'mefInsuranceDetailsTable8'
            )
            ->findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'insurance';

            return Excel::download(
                new ExcelService($master_data),
                'insurance_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefInsuranceController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request, InsuranceService $insuranceService)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $insuranceService->summaryReport($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'insurance';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'insurance_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }

}
