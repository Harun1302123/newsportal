<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use Exception;
use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefBankMasterRequest;
use App\Http\Controllers\Controller;
use App\Modules\MonitoringFramework\Models\Bank\MefBankMaster;
use App\Modules\MonitoringFramework\Models\Bank\MefBankTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Services\BankService;
use App\Modules\MonitoringFramework\Services\ExcelService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class MefBankController extends Controller {

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
        $this->service_id = 48;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'banks.list';
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
                return mefDatatableList(new MefBankMaster(), 'banks', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'Bank Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('banks.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('banks.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }

            return view('MonitoringFramework::mef_list', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in MefBankController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefBankMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try{
            if (!($this->add_permission)) {
                Session::flash('error', "Don't have create permission");
                return redirect()->route($this->list_route);
            }
            $data['card_title'] = 'Data Entry Form (Bank)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;

            $tables = MefBankTable::query()->get();
            if (count($tables->toArray())) {
                foreach ($tables as $value) {
                    $data["$value->table_name"] = bankTableWiseLabels($value->id);
                }
            }
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Bank.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::banks.create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in MefBankController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-102]");
            return redirect()->back();
        }
    }

    /**
     * @param StoreMefBankMasterRequest $request
     * @param BankService $bankService
     * @return RedirectResponse
     */
    public function store(StoreMefBankMasterRequest $request, BankService $bankService): RedirectResponse
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            // call store service
            $bankService->store($request);

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefBankMaster-103]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = MefBankMaster::query()
                ->with(
                    'mefBankDetailsTable1_1','mefBankDetailsTable1_2','mefBankDetailsTable1_3','mefBankDetailsTable1_4','mefBankDetailsTable1_5','mefBankDetailsTable2_1_1',
                    'mefBankDetailsTable2_1_2','mefBankDetailsTable2_2_1','mefBankDetailsTable2_2_2','mefBankDetailsTable3_1',
                    'mefBankDetailsTable3_2','mefBankDetailsTable3_3','mefBankDetailsTable4_1','mefBankDetailsTable4_2',
                    'mefBankDetailsTable5','mefBankDetailsTable6','mefBankDetailsTable7','mefBankDetailsTable8','mefBankDetailsTable9',
                    'mefBankDetailsTable10','mefBankDetailsTable12'
                )
                ->findOrFail($decode_id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['approve_btn'] = '';
            $data['check_btn'] = '';
            $data['excel_btn'] = '';
            if ($this->approve && $data['master_data']->mef_process_status_id != 25) {
                $data['approve_btn'] = '<a href="' . route('banks.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            }
            if ($this->checker && $data['master_data']->mef_process_status_id != 9) {
                $data['check_btn'] = '<a href="' . route('banks.check', ['id' => $id]) . '" class="btn btn-flat btn-success btn-xs m-1"> Check </a>';
            }
            $data['excel_btn'] = '<a href="' . route('banks.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';

            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/Bank.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::banks.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-104]");
            return redirect()->back();
        }
    }

    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_bank_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('banks.summary_report_data');
            $data['card_title'] = 'Bank Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request, BankService $bankService): View|RedirectResponse
    {
        try {
            // call service function
            $data = $bankService->summaryReport($request);
            $data['list_route'] = $this->list_route;
            return view('MonitoringFramework::banks.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-105]");
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
            $data['master_data'] = MefBankMaster::query()
                ->with(
                    'mefBankDetailsTable1_1','mefBankDetailsTable1_2','mefBankDetailsTable1_3','mefBankDetailsTable1_4','mefBankDetailsTable1_5','mefBankDetailsTable2_1_1',
                    'mefBankDetailsTable2_1_2','mefBankDetailsTable2_2_1','mefBankDetailsTable2_2_2','mefBankDetailsTable3_1',
                    'mefBankDetailsTable3_2','mefBankDetailsTable3_3','mefBankDetailsTable4_1','mefBankDetailsTable4_2',
                    'mefBankDetailsTable5','mefBankDetailsTable6','mefBankDetailsTable7','mefBankDetailsTable8','mefBankDetailsTable9',
                    'mefBankDetailsTable10','mefBankDetailsTable12'
                )
                ->findOrFail($decode_id);
            $data['id'] = $id;
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Bank Data';
            $data['list_route'] = $this->list_route;
            $data['view_btn'] = '<a href="' . route('banks.view', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Preview </a>';

            if (!($data['master_data']->mef_process_status_id == '-1' || $data['master_data']->mef_process_status_id == 5)) {
                Session::flash('error', "This data status is not editable");
                return redirect()->route($this->list_route);
            }

            return view('MonitoringFramework::banks.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-106]");
            return redirect()->back();
        }
    }

    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefBankMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefBankTable::query()->get();
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
            Log::error("Error occurred in MefBankController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefBankMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-108]");
            return redirect()->back();
        }
    }

    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefBankMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-109]");
            return false;
        }
    }

    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefBankMaster::query()
                ->with(
                    'mefBankDetailsTable1_1','mefBankDetailsTable1_2','mefBankDetailsTable1_3','mefBankDetailsTable1_4','mefBankDetailsTable1_5','mefBankDetailsTable2_1_1',
                    'mefBankDetailsTable2_1_2','mefBankDetailsTable2_2_1','mefBankDetailsTable2_2_2','mefBankDetailsTable3_1',
                    'mefBankDetailsTable3_2','mefBankDetailsTable3_3','mefBankDetailsTable4_1','mefBankDetailsTable4_2',
                    'mefBankDetailsTable5','mefBankDetailsTable6','mefBankDetailsTable7','mefBankDetailsTable8','mefBankDetailsTable9',
                    'mefBankDetailsTable10','mefBankDetailsTable12'
                )
                ->findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'banks';

            return Excel::download(
                new ExcelService($master_data),
                'bank_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request, BankService $bankService)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $bankService->summaryReport($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'banks';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'banks_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }

}
