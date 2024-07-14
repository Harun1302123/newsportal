<?php

namespace App\Modules\MonitoringFramework\Http\Controllers;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Modules\MonitoringFramework\Http\Requests\StoreMefIndicatorMasterRequest;
use App\Http\Controllers\Controller;
use App\Modules\MonitoringFramework\Models\Indicator\MefIndicatorMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\MefPublishedScoreRecord;
use App\Modules\MonitoringFramework\Models\MefShortfallRecord;
use App\Modules\MonitoringFramework\Services\IndicatorService;
use App\Modules\SignUpOrganization\Models\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MefIndicatorController extends Controller
{
    protected int $service_id;
    protected int $add_permission;
    protected int $edit_permission;
    protected int $view_permission;
    protected string $list_route;

    public function __construct()
    {
        $this->service_id = 56;
        $this->list_route = 'indicators.list';
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
                $list = MefIndicatorMaster::query()
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
                        $status =  '<span class="badge text-white" style="background-color: '.$row->mefProcessStatus->color.' " >'.$row->mefProcessStatus->status_name.'</span>';
                        return $status;
                    })
                    ->addColumn('action', function ($row) {
                        $unpublish_btn = '';
                        $view_btn = '<a href="' . route('indicators.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
                        if ($row->mef_process_status_id == 10) {
                            $unpublish_btn = '<a href="' . route('indicators.unpublish', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-warning btn-xs m-1"  onclick="return confirm(\'Are you sure?\')"> Unpublish </a><br>';
                        }
                        $portalStatus = scoreStatusChecking($row->year, $row->mef_quarter_id);
                        if ($portalStatus != "Inactive") {
                            $unpublish_btn = '';
                        }
                        return $view_btn . $unpublish_btn;
                    })
                    ->rawColumns(['action', 'mef_process_status_id'])
                    ->make(true);
            }

            return view('MonitoringFramework::indicators.list', [
                'add_permission' => $this->add_permission,
                'edit_permission' => $this->edit_permission,
                'view_permission' => $this->view_permission,
            ]);

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [MefIndicatorMaster-101]");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function create(): View|RedirectResponse
    {

        // $benchmark = getBenchmarkData( 2022, 1, 'indicator_set_a' );
        // dd($benchmark);
        try{
            if (!($this->add_permission)) {
                Session::flash('error', "Don't have create permission");
                return redirect()->route($this->list_route);
            }
            $data['card_title'] = 'Create Indicator Data';
            $data['list_route'] = $this->list_route;
            $data['add_permission'] = $this->add_permission;

            $data['set_indicator_details'] = getSetIndicatorDetails();

            return view('MonitoringFramework::indicators.create', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-102]");
            return redirect()->back();
        }
    }

    
    public function store(StoreMefIndicatorMasterRequest $request, IndicatorService $IndicatorService)
    {
        try {
            if (!($this->add_permission || $this->edit_permission)) {
                Session::flash('error', "Don't have add permission");
                return redirect()->route($this->list_route);
            }
            // call store service 
            $IndicatorService->store($request);

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefIndicatorMaster-103]");
            return Redirect::back()->withInput();
        }
    }

    public function view($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $mefIndicatorMaster = MefIndicatorMaster::query()
                ->with( 'mefIndicatorDetailsRecord','mefIndicatorSetDetailsRecord')
                ->findOrFail($decode_id);

            $data['master_data'] = mefIndicatorMasterDataDetails($mefIndicatorMaster);
            $data['quarter'] = $mefIndicatorMaster->mef_quarter_id??null;
            $data['year'] = $mefIndicatorMaster->year??null;
            $data['prev_year'] = (($mefIndicatorMaster->mef_quarter_id == 1) ? ($mefIndicatorMaster->year - 1) : $mefIndicatorMaster->year);
            $data['prevQuarter'] = quarterCalculation($data['quarter'], 'prev')??null;
            $data['quarterText'] = quarterText($data['quarter'])??null;
            $data['prevQuarterText'] = quarterText($data['quarter'], 'prev')??null;
            $data['list_route'] = $this->list_route;

            return view('MonitoringFramework::indicators.view', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@view ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-104]");
            return redirect()->back();
        }
    }

    
    public function edit($id): View|RedirectResponse
    {
        try {
            if (!($this->edit_permission)) {
                Session::flash('error', "Don't have edit permission");
                return redirect()->route($this->list_route);
            }

            $decode_id = Encryption::decodeId($id);
            $data['master_data'] = MefIndicatorMaster::query()->findOrFail($decode_id);
            $data['id'] = $id;
            $data['edit_permission'] = $this->edit_permission;
            $data['card_title'] = 'Edit Indicator Data';
            $data['list_route'] = $this->list_route;

            return view('MonitoringFramework::indicators.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-105]");
            return redirect()->back();
        }
    }

    public function summaryReport(IndicatorService $IndicatorService): View|RedirectResponse
    {
        try {
            // call service function 
            $data = $IndicatorService->summaryReport();
            $data['list_route'] = $this->list_route;
            $data['set_indicator_details'] = getSetIndicatorDetails();

            return view('MonitoringFramework::indicators.summary_report', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-106]");
            return redirect()->back();
        }
    }


    public function indicatorTotalScoreForm( Request $request ): View|RedirectResponse
    {
        try {
            $data['set_indicator_details'] = getSetIndicatorDetails();
            $data['quarter'] = $request->quarter??null;
            $data['year'] = $request->year??null;
            $data['prev_year'] = (($request->quarter == 1) ? ($request->year - 1) : $request->year);
            $data['prevQuarter'] = quarterCalculation($data['quarter'], 'prev')??null;
            $data['quarterText'] = quarterText($data['quarter'])??null;
            $data['prevQuarterText'] = quarterText($data['quarter'], 'prev')??null;
            $data['getSetWiseManualData'] = getSetWiseManualData($data['quarter'], $data['year']);

            return view('MonitoringFramework::indicators.form_partials.indicator_total_score_form', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@indicatorTotalScoreForm ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-107]");
            return redirect()->back();
        }
    }

    public function unpublish($id): RedirectResponse
    {
        try {
            $master_id = Encryption::decodeId($id);
            $master_data = MefIndicatorMaster::findOrFail($master_id);
            if ($master_data->mef_process_status_id == 13) {
                Session::flash('error', "Data already unpublish!");
                return redirect()->back();
            }
            $master_data->mef_process_status_id = 13; // Unpublished
            $master_data->is_approved = 0; 
            $master_data->save();

            Session::flash('success', 'Data successfully unpublish!');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@check ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorMaster-108]");
            return redirect()->back();
        }
    }


    public function publishedIndicatorData( Request $request ): array|JsonResponse
    {
        try {
            $data['quarter'] = $request->quarter??null;
            $data['year'] = $request->year??null;
            $mefIndicatorMaster = MefIndicatorMaster::query()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->where('mef_process_status_id', 10)->where('is_approved', 1)->first();
            $data['master_data'] = [];
            if ($mefIndicatorMaster) {
                $data['master_data'] = mefIndicatorMasterDataDetails($mefIndicatorMaster);
            }

            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@publishedIndicatorData ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function organizationWiseDataDashboard( Request $request ): View|RedirectResponse
    {
        try {
            $data['quarter'] = $request->quarter??null;
            $data['year'] = $request->year??null;

            return view('MonitoringFramework::organization_wise_data_dashboard', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@organizationWiseDataDashboard ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return redirect()->back();
        }
    }
    
    public function integratedIndexScore(): View|RedirectResponse
    {
        try {
            return view('MonitoringFramework::interpretation_of_integrated_index_score');
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@organizationWiseDataDashboard ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return redirect()->back();
        }
    }

    public function scoreRecordPublish(Request $request)
    {
        try {            
            DB::beginTransaction();
            $master_data = new MefPublishedScoreRecord();
            if ($master_data->count()) {
                DB::table("mef_published_score_records")
                ->update(
                    [
                        "is_active" => 0, // inactive all data
                    ]
                );
            }
            $master_data->mef_quarter_id = $request->quarter ?? null; 
            $master_data->year = $request->year ?? null; 
            $master_data->is_active = 1; // active current data
            $master_data->indicator_score = $request->indicator_score ?? null; 
            $master_data->goal_tracking_score = $request->goal_tracking_score ?? null; 
            $master_data->save();
            DB::commit();

            Session::flash('success', 'Data successfully publish!');
            return true;

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@scoreRecordPublish ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return false;
        }
    }

    public function setWiseIndicatorsInfo( Request $request ): array|JsonResponse
    {
        try {
            $set_id = $request->set_id ?? null;
            $data['setTitle'] = getSetInfo($set_id)->title;
            $data['setTitleBn'] = getSetInfo($set_id)->title_bn;
            $data['indicatorInfo'] = getSetWiseIndicators($set_id)->pluck('name');
            $data['indicatorInfoBn'] = getSetWiseIndicators($set_id)->pluck('name_bn');

            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@setWiseIndicatorsInfo ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function shortfallHistory( Request $request ): JsonResponse|Collection
    {
        try {
            $service_id = $request->service_id ?? null;
            $master_id = $request->master_id ?? null;
            return MefShortfallRecord::query()->where('service_id', $service_id)->where('master_id', $master_id)->orderByDesc('id')->pluck('reject_reason');

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@shortfallHistory ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function organizationInfo( Request $request ): JsonResponse|Collection|array
    {
        try {
            $organizations = $request->organizations ?? null;
            if (!$organizations) {
                return [];
            }
            return Organization::query()->whereIn('id', $organizations)->whereStatus(1)->pluck('organization_name_en');

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@organizationInfo ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function portalPublishScore()
    {
        try {
            
            $item = MefPublishedScoreRecord::query()->where('is_active', 1)->first();
            if (!$item) {
                return [];
            }
            $totalScore = $item->indicator_score + $item->goal_tracking_score;
            $interpretationCondition = interpretationCondition($totalScore);
            return $interpretationCondition;

        } catch (\Exception $e) {
            Log::error("Error occurred in MefIndicatorController@portalPublishScore ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong");
            return response()->json(['error' => CommonFunction::showErrorPublic($e->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



}
