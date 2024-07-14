<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefNsdMasterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Modules\MonitoringFramework\Models\Nsd\MefNsdMaster;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Nsd\MefNsdDetailsTable1;
use App\Modules\MonitoringFramework\Models\Nsd\MefNsdDetailsTable2;
use App\Modules\MonitoringFramework\Models\Nsd\MefNsdTable;
use App\Modules\MonitoringFramework\Services\ExcelService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class MefNsdController extends Controller
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
        $this->service_id = 54;
        ACL::mefServiceWiseAccess($this->service_id);
        list($this->add_permission, $this->edit_permission, $this->view_permission) = ACL::getAccessRight($this->service_id);
        list($this->provide, $this->approve, $this->checker) = ACL::getProvideApprovePublishPermission($this->service_id);
        $this->list_route = 'nsd.list';
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
                return mefDatatableList(new MefNsdMaster(), 'nsd', $this->edit_permission, $this->approve, $this->checker, $request);
            }

            $data['add_permission'] = $this->add_permission;
            $data['edit_permission'] = $this->edit_permission;
            $data['view_permission'] = $this->view_permission;
            $data['list_route'] = $this->list_route;
            $data['card_title'] = 'NSD Data List';
            $data['orgTypeId'] = orgTypeInfoByServiceId($this->service_id)->id;
            $data['create_btn'] = '';
            if ($this->add_permission){
                $data['create_btn'] = '<a href="' . route('nsd.create') . '" type="button" class="btn btn-primary "><i class="fa fa-plus"></i> Create New </a>';
            }
            $data['summary_btn'] = '';
            if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)){
                $data['summary_btn'] = '<a href="' . route('nsd.summary_report') . '" type="button" class="btn btn-info "><i class="fa fa-eye"></i> Summary Report </a>';
            }
            return view('MonitoringFramework::mef_list', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefNsdMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if ($this->add_permission) {
            $data['card_title'] = 'Data Entry Form (NSD)';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;
            $data['divisions'] = getDivisions();
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/NSD.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::nsd.create', $data);
        }
        return redirect()->back()->with('error', "Don't have create permission.");
    }

    /**
     * @return RedirectResponse
     */
    public function store(StoreMefNsdMasterRequest $request)
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefNsdMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefNsdMaster = MefNsdMaster::findOrFail($master_id);
            } else {
                $mefNsdMaster = new MefNsdMaster();
            }

            $mefNsdMaster->year = $request->year ?? null;
            $mefNsdMaster->mef_quarter_id = $request->quarter ?? null;
            $mefNsdMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefNsdMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefNsdMaster->mef_process_status_id = 1; // Submitted
            }
            $mefNsdMaster->save();

            // MefNsdDetailsTable1
            foreach ($request->district_id as $key => $item) {
                $detailsTableId1 = $request->mef_nsd_details_table_1_id[$key] ?? null;
                $table1 = MefNsdDetailsTable1::findOrNew($detailsTableId1);
                $table1->master_id = $mefNsdMaster->id;
                $table1->district_id = $item;
                $table1->division_id = $request->division_id[$key] ?? null;
                $table1->nb_nsc_male = $request->nb_nsc_male[$key] ?? null;
                $table1->nb_nsc_female = $request->nb_nsc_female[$key] ?? null;
                $table1->nb_nsc_others = $request->nb_nsc_others[$key] ?? null;
                $table1->nb_nsc_joint = $request->nb_nsc_joint[$key] ?? null;
                $table1->nb_nsc_total =  intval($request->nb_nsc_male[$key]) + intval($request->nb_nsc_female[$key]) + intval($request->nb_nsc_others[$key]) +  intval($request->nb_nsc_joint[$key]) ;
                $table1->na_bpo_male = $request->na_bpo_male[$key] ?? null;
                $table1->na_bpo_female = $request->na_bpo_female[$key] ?? null;
                $table1->na_bpo_others = $request->na_bpo_others[$key] ?? null;
                $table1->na_bpo_total =  intval($request->na_bpo_male[$key]) + intval($request->na_bpo_female[$key]) + intval($request->na_bpo_others[$key]);
                $table1->np_liph_male = $request->np_liph_male[$key] ?? null;
                $table1->np_liph_female = $request->np_liph_female[$key] ?? null;
                $table1->np_liph_others = $request->np_liph_others[$key] ?? null;
                $table1->np_liph_total =  intval($request->np_liph_male[$key]) + intval($request->np_liph_female[$key]) + intval($request->np_liph_others[$key]);
                $table1->save();
            }

            // MefNsdDetailsTable2
            foreach ($request->district_id_1_1 as $key => $item) {
                $detailsTableId1_1 = $request->mef_nsd_details_table_1_1_id[$key] ?? null;
                $table2 = MefNsdDetailsTable2::findOrNew($detailsTableId1_1);
                $table2->master_id = $mefNsdMaster->id;
                $table2->district_id = $item;
                $table2->division_id = $request->division_id_1_1[$key] ?? null;
                $table2->bo_nsc_male = $request->bo_nsc_male_1_1[$key] ?? null;
                $table2->bo_nsc_female = $request->bo_nsc_female_1_1[$key] ?? null;
                $table2->bo_nsc_others = $request->bo_nsc_others_1_1[$key] ?? null;
                $table2->bo_nsc_joint = $request->bo_nsc_joint_1_1[$key] ?? null;
                $table2->bo_nsc_total =  intval($request->bo_nsc_male_1_1[$key] ?? 0) + intval($request->bo_nsc_female_1_1[$key] ?? 0) + intval($request->bo_nsc_others_1_1[$key] ?? 0) + intval($request->bo_nsc_joint_1_1[$key] ?? 0) ;
                $table2->db_bpo_male = $request->db_bpo_male_1_1[$key] ?? null;
                $table2->db_bpo_female = $request->db_bpo_female_1_1[$key] ?? null;
                $table2->db_bpo_others = $request->db_bpo_others_1_1[$key] ?? null;
                $table2->db_bpo_total =  intval($request->db_bpo_male_1_1[$key] ?? 0) + intval($request->db_bpo_female_1_1[$key] ?? 0) + intval($request->db_bpo_others_1_1[$key] ?? 0);
                $table2->bp_lip_male = $request->bp_lip_male_1_1[$key] ?? null;
                $table2->bp_lip_female = $request->bp_lip_female_1_1[$key] ?? null;
                $table2->bp_lip_others = $request->bp_lip_others_1_1[$key] ?? null;
                $table2->bp_lip_total =  intval($request->bp_lip_male_1_1[$key] ?? 0) + intval($request->bp_lip_female_1_1[$key] ?? 0) + intval($request->bp_lip_others_1_1[$key] ?? 0);
                $table2->save();
            }

            DB::commit();

            Session::flash('success', 'Data save successfully!');
            return redirect()->route("$this->list_route");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefNsdController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefNsdMaster-102]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id)
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['list_route'] = $this->list_route;
            $data['service_id'] = $this->service_id;
            $data['master_data'] = MefNsdMaster::query()->with('mefNsdDetailsTable1', 'mefNsdDetailsTable2')->findOrFail($decode_id);
            $data['approve_btn'] = '<a href="' . route('nsd.approve', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a>';
            $data['check_btn'] = '<a href="' . route('nsd.check', ['id' => $id]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Check </a>';
            $data['excel_btn'] = '<a href="' . route('nsd.excel', ['id' => $id]) . '" class="btn btn-flat btn-info btn-xs m-1"> Excel Download </a>';
            $data['explanation_btn'] = '<a href="' . asset('docs/Mef/NSD.pdf') . '" target="_blank" type="button" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Explanation </a>';

            return view('MonitoringFramework::nsd.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefNsdMaster-103]");
            return redirect()->back();
        }
    }

    public function summaryReport(): View|RedirectResponse
    {
        try {
            $data['list_route'] = $this->list_route;
            $lastApprovedDataInfo = mefLastApprovedDataInfo('mef_nsd_master_records');
            $data['year'] = $lastApprovedDataInfo->year??null;
            $data['quarter'] = $lastApprovedDataInfo->mef_quarter_id??null;
            $data['action_route'] = route('nsd.summary_report_data');
            $data['card_title'] = 'NSD Summery Data';
            return view('MonitoringFramework::summary_report_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNSDController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNSDMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReportData(Request $request)
    {
        try {
            $data = $this->summaryReportService($request);
            $data['list_route'] = $this->list_route;
            return view('MonitoringFramework::nsd.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefNsdMaster-103]");
            return redirect()->back();
        }
    }

    private function summaryReportService($request)
    {
        try {
            $data['mefNsdDetailsTable1'] = MefNsdDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNsdDetailsTable2'] = MefNsdDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();

            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
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
                $data['master_data'] = MefNsdMaster::query()->with('mefNsdDetailsTable1', 'mefNsdDetailsTable2')->findOrFail($decode_id);
                $data['id'] = $id;
                $data['edit_permission'] = $this->edit_permission;
                $data['card_title'] = 'Edit NSD';
                $data['list_route'] = $this->list_route;
                $data['divisions'] = getDivisions();

                if (!($data['master_data']->mef_process_status_id == '-1' || $data['master_data']->mef_process_status_id == 5)) {
                    Session::flash('error', "This data status is not editable");
                    return redirect()->route($this->list_route);
                }

                return view('MonitoringFramework::nsd.edit', $data);
            }
            return redirect()->back()->with('error', "Don't have edit permission.");
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefNsdMaster-103]");
            return redirect()->back();
        }
    }


    public function approve($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefNsdMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 25) {
                Session::flash('error', "Data already approved!");
                return redirect()->back();
            }
            DB::beginTransaction();
            $master_data->mef_process_status_id = 25; // Approved
            $master_data->save();
            $tables = MefNsdTable::query()->get();
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
            Log::error("Error occurred in MefNsdController@approve ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNsdMaster-107]");
            return redirect()->back();
        }
    }

    public function check($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefNsdMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 9) {
                Session::flash('error', "Data already checked!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 9; // Checked
            $master_data->save();

            Session::flash('success', 'Data successfully checked!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNsdMaster-108]");
            return redirect()->back();
        }
    }

    public function shortfall(Request $request, $id): bool
    {
        try {
            return mefShortfall(new MefNsdMaster(), $id, $request, $this->service_id);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNsdMaster-109]");
            return false;
        }
    }


    public function excel($id)
    {
        try{
            $decode_id = Encryption::decodeId($id);
            $master_data = MefNsdMaster::query()->with('mefNsdDetailsTable1', 'mefNsdDetailsTable2')->findOrFail($decode_id);
            $master_data->viewType = 'excel';
            $master_data->source = 'nsd';

            return Excel::download(
                new ExcelService($master_data),
                'nsd_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefNsdController@excel ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNsdMaster-110]");
            return false;
        }
    }

    public function excelForSummaryData(Request $request)
    {
        try{
            $master_data = new stdClass();
            $master_data->data = $this->summaryReportService($request);
            $master_data->viewType = 'excel';
            $master_data->source = 'nsd';
            $master_data->sourceType = 'summary';

            return Excel::download(
                new ExcelService($master_data),
                'nsd_summary_data.xlsx'
            );
        } catch (\Exception $e) {
            Log::error("Error occurred in MefBankController@excelForSummaryData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankMaster-111]");
            return false;
        }
    }

}
