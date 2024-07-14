<?php

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\ManualDataEntry\Models\MefBenchmark;
use Yajra\DataTables\DataTables;
use App\Modules\MonitoringFramework\Models\Bank\MefBankLabel;
use App\Modules\MonitoringFramework\Models\Bank\MefBankMaster;
use App\Modules\MonitoringFramework\Models\Indicator\MefIndicatorMaster;
use App\Modules\MonitoringFramework\Models\MefIndicator;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceLabel;
use App\Modules\MonitoringFramework\Models\MefProcessStatus;
use App\Modules\MonitoringFramework\Models\MefQuarter;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisLabel;
use App\Modules\MonitoringFramework\Models\Nsd\MefNsdLabel;
use App\Modules\MonitoringFramework\Models\MefSet;
use App\Modules\MonitoringFramework\Models\MefShortfallRecord;
use App\Modules\MonitoringFramework\Models\MefYear;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisLabel;
use App\Modules\SignUpOrganization\Models\Organization;
use App\Modules\Users\Models\Organigation;
use App\Modules\Users\Models\OrganizationType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

function getSetIndicatorDetails()
{
    return Cache::rememberForever('set_indicator_details', function()
    {
        return MefSet::query()->with('mefDimension:id,name', 'mefIndicator')->whereStatus(1)->orderBy('name')->get()->map(function($set){
            return [
                'dimension_name' => $set->mefDimension->name??null,
                'set_id' => $set->id??null,
                'set_name' => $set->name??null,
                'set_title' => $set->title??null,
                'indicators' => $set->mefIndicator->map(function($indicator) {
                    return [
                        'org_type' => $indicator->organizationType->org_type_short_name??null,
                        'indicator_id' => $indicator->id??null,
                        'indicator_name' => $indicator->name??null,
                        'source_table' => $indicator->source_table??null,
                        'source_column' => $indicator->source_column??null,
                        'label_column' => $indicator->label_column??null,
                        'label_id' => $indicator->label_id??null,
                        'is_nau' => $indicator->is_nau??null,
                        'is_multiple_column' => $indicator->is_multiple_column??null,
                    ];
                }),
            ];
        });
    });

}

function getSetWiseIndicators($mef_set_id)
{
    $cacheKey = 'set_wise_indicators_info_set_' . $mef_set_id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() use ($mef_set_id) {
            return MefIndicator::query()->with('organizationType:id,org_type_short_name')->where('mef_set_id', $mef_set_id)->get();
        });
    }
}

function getSetInfo($mef_set_id)
{
    $cacheKey = 'set_info_set_' . $mef_set_id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() use ($mef_set_id) {
            return MefSet::query()->findOrFail($mef_set_id);
        });
    }
}


function bankTableWiseLabels($mef_bank_table_id)
{
    return MefBankLabel::query()->where('mef_bank_table_id', $mef_bank_table_id)->orderBy('order')->get();
}


function nbfisTableWiseLabels($mef_nbfis_table_id)
{
    return MefNbfisLabel::query()->where('mef_nbfis_table_id', $mef_nbfis_table_id)->orderBy('order')->get();
}

function mfisTableWiseLabels($mef_mfis_table_id)
{
    return MefMfisLabel::query()->where('mef_mfis_table_id', $mef_mfis_table_id)->orderBy('order')->get();
}

function insuranceTableWiseLabels($mef_insurance_table_id)
{
    return MefInsuranceLabel::query()->where('mef_insurance_table_id', $mef_insurance_table_id)->orderBy('order')->get();
}

function nsdTableWiseLabels($mef_nsd_table_id)
{
    return MefNsdLabel::query()->where('mef_nsd_table_id', $mef_nsd_table_id)->orderBy('order')->get();
}

function approvalUpdateQuery($source_table, $master_id, $quarter_id, $year)
{
    try{
        DB::beginTransaction();
            DB::table("$source_table")
            ->where('master_id', $master_id)
            ->update(
                [
                    "mef_quarter_id" => $quarter_id,
                    "year" => $year,
                    "is_approved" => 1,
                ]
            );
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Error occurred in ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
        Session::flash('error', "Something went wrong [MEF-Helper-101]");
        return redirect()->back();
    }

}

function publisherReviewUpdateQuery($source_table, $master_id, $quarter_id, $year)
{
    try{
        DB::beginTransaction();
            DB::table("$source_table")
            ->where('master_id', $master_id)
            ->update(
                [
                    "mef_quarter_id" => $quarter_id,
                    "year" => $year,
                    "is_approved" => 2, // publisher review
                ]
            );
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Error occurred in ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
        Session::flash('error', "Something went wrong [MEF-Helper-102]");
        return redirect()->back();
    }

}

function getIndicatorValueMultipleColumnWise($source_table, $source_column, $label_column, $label_id, $quarter_id, $year)
{
    if (count($source_table)) {
        $multipleValue = 0;
        foreach ($source_table as $key => $table) {
            $multipleValue += getIndicatorValueTableWise($table, $source_column[$key], $label_column, $label_id, $quarter_id, $year);
        }
        return $multipleValue;
    }
    return null;
}

function getIndicatorValueTableWise($source_table, $source_column, $label_column, $label_id, $quarter_id, $year)
{
    if (!$source_table || !$source_column || !$quarter_id || !$year) {
        return null;
    }
    return DB::table("$source_table")
        ->selectRaw("SUM($source_column) as indicator_value")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('is_approved', 1)
        ->when($label_column, function($query) use($label_column,$label_id){
            return $query->where("$label_column", $label_id);
        })
        ->value('indicator_value');
}

function getIndicatorNauValue($indicator_id, $source_table, $source_column, $label_column, $label_id, $quarter_id, $year)
{
    if (!$indicator_id || !$source_table || !$source_column || !$quarter_id || !$year) {
        return null;
    }
    return DB::table("$source_table")
        ->selectRaw("$source_column as indicator_value")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('is_approved', 1)
        ->where('indicator_id', $indicator_id)
        ->when($label_column, function($query) use($label_column,$label_id){
            return $query->where("$label_column", $label_id);
        })
        ->value('indicator_value');
}

function getSetWiseManualData($quarter_id, $year)
{
    if (!$quarter_id || !$year) {
        return [];
    }
    return DB::table("mef_set_manual_data_details_records")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('is_approved', 1)
        ->pluck('set_info', 'set_id');
}

function mefSets()
{
    $cacheKey = 'mef_sets';
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() {
            return MefSet::query()->whereStatus(1)->get();
        });
    }
}

function mefProcessStatus()
{
    $cacheKey = 'mef_process_status';
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() {
            return MefProcessStatus::query()->whereStatus(1)->pluck('status_name', 'id')->except([2,13]);
        });
    }
}

function orgTypeInfoByServiceId($service_id)
{
    $cacheKey = 'org_type_info_by_service_id_'.$service_id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() use($service_id) {
            return OrganizationType::query()->where('service_id', $service_id)->first();
        });
    }
}

function organigations($organization_type=null)
{
    return Organigation::query()
        ->when($organization_type, function ($query) use($organization_type) {
            return $query->where('organization_type', $organization_type);
        })
        ->when(Auth::user()->organization_id, function ($query) {
            return $query->where('id', Auth::user()->organization_id);
        })
        ->whereStatus(1)
        ->pluck('organization_name_en', 'id');
}

function organizationTypes()
{
    return Cache::rememberForever('organization_types', function()
    {
        return OrganizationType::query()->with('services')->whereStatus(1)->get();
    });
}

function organizationWiseDataDashboard($organization_type, $master_table, $year, $mef_quarter_id)
{
    $total_org = Organization::query()->where('organization_type', $organization_type)->whereStatus(1)->get();
    $approved = DB::table("$master_table")->where('year', $year)->where('mef_quarter_id', $mef_quarter_id)->where('mef_process_status_id', 25)->distinct()->select('organization_id')->get();
    $unapproved = DB::table("$master_table")->where('year', $year)->where('mef_quarter_id', $mef_quarter_id)->whereNot('mef_process_status_id', 25)->distinct()->select('organization_id')->get();
    $master_data_organizations = DB::table("$master_table")->where('year', $year)->where('mef_quarter_id', $mef_quarter_id)->distinct()->select('organization_id')->pluck('organization_id');

    $data['approved_percentage'] = get_percentage($approved->count(), $total_org->count());
    $data['unapproved_percentage'] = get_percentage($unapproved->count(), $total_org->count());
    $not_provided = 100 - ($data['approved_percentage'] + $data['unapproved_percentage']);
    $data['not_provided_percentage'] = number_format($not_provided, 2);

    $data['approved_list'] = $approved->pluck('organization_id');
    $data['unapproved_list'] = $unapproved->pluck('organization_id');
    $data['not_provided_list'] = $total_org->whereNotIn('id', $master_data_organizations)->pluck('id');

    return $data;
}

function get_percentage($num_amount, $num_total)
{
    $percentage = ($num_amount / $num_total) * 100;
    return number_format($percentage, 2);
}


function quarters()
{
    return Cache::rememberForever('quarters', function()
    {
        return MefQuarter::query()->pluck('name', 'id');
    });
}

function benchmarks()
{
    return Cache::rememberForever('benchmarks', function()
    {
        return MefBenchmark::query()->pluck('name', 'id');
    });
}

function benchmarkInfo($id)
{
    $cacheKey = 'benchmarkInfo_id_'.$id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() use($id) {
            return MefBenchmark::findOrFail($id);
        });
    }
}

function years()
{
    return Cache::rememberForever('years', function()
    {
        return MefYear::query()->whereStatus(1)->pluck('year', 'year');
    });
}

function quarterText($quarter_id, $findText=null)
{
    if (!$findText) {
        $quarterInfo = MefQuarter::query()->findOrFail($quarter_id);
    }elseif($findText == 'prev') {
        if ($quarter_id == 1) {
            $quarter_id = 5; // 5-1 will be 4th Q
        }
        $prevQuarterId = ($quarter_id-1)??null;
        $quarterInfo = MefQuarter::query()->findOrFail($prevQuarterId);
    }elseif($findText == 'next') {
        if ($quarter_id == 4) {
            $quarter_id = 0; // 0+1 will be 1st Q
        }
        $nextQuarterId = ($quarter_id+1)??null;
        $quarterInfo = MefQuarter::query()->findOrFail($nextQuarterId);
    }
    return $quarterInfo->name;
}

function quarterCalculation($quarter_id, $findText=null)
{
    if($findText == 'prev') {
        if ($quarter_id == 1) {
            $quarter_id = 5; // 5-1 will be 4th Q
        }
        return ($quarter_id-1)??null;
    }elseif($findText == 'next') {
        if ($quarter_id == 4) {
            $quarter_id = 0; // 0+1 will be 1st Q
        }
        return ($quarter_id+1)??null;
    }
    return $quarter_id;
}

function mefBankYears() {
    return MefBankMaster::distinct()->select('year')->orderBy('year')->pluck('year', 'year');
}

function staticYears($startValue=null, $endValue=null)
{
    $startValue = $startValue??2010;
    $endValue = $endValue??date('Y');
    $result = [];
    for ($i=$startValue; $i <= $endValue; $i++) {
        $result[$i] = $i;
    }
    return $result;
}

function mefIndicatorMasterDataDetails($mefIndicatorMaster)
{
    $cacheKey = 'published_set_indicator_details_year_' . $mefIndicatorMaster->year .'_quarter_'. $mefIndicatorMaster->mef_quarter_id .'_process_status_'. $mefIndicatorMaster->mef_process_status_id .'_master_id_'. $mefIndicatorMaster->id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() use($mefIndicatorMaster) {
            return [
                'dimension_wise_info' => $mefIndicatorMaster->dimension_wise_info??null,
                'details' => $mefIndicatorMaster->mefIndicatorSetDetailsRecord->map(function($set) use($mefIndicatorMaster) {
                    return [
                        'dimension_name' => $set->mefSet->mefDimension->name??null,
                        'set_name' => $set->mefSet->name??null,
                        'set_title' => $set->mefSet->title??null,
                        'set_wise_info' => $set->set_wise_info ? json_decode($set->set_wise_info) : null,
                        'indicators' => $mefIndicatorMaster->mefIndicatorDetailsRecord->where('mef_set_id', $set->mef_set_id)->map(function($indicator) {
                            return [
                                'org_type' => $indicator->mefIndicator->organizationType->org_type_short_name??null,
                                'indicator_name' => $indicator->mefIndicator->name??null,
                                'previous_value' => $indicator->previous_value??null,
                                'current_value' => $indicator->current_value??null,
                                'changes_percentage' => $indicator->changes_percentage??null,
                                'score' => $indicator->score??null,
                            ];
                        }),
                    ];
                }),
            ];
        });
    }

}

function rejectCardInfo($reject_reason = null, $master_id = null, $service_id = null, $mef_process_status_id = null)
{
    $data['reject_reason'] = $reject_reason??null;
    $data['master_id'] = $master_id??null;
    $data['service_id'] = $service_id??null;
    $data['mef_process_status_id'] = $mef_process_status_id??null;
    return view("MonitoringFramework::reject_card", $data);
}

function mefDatatableList($model, $prefix, $edit_permission, $approve, $checker, $request=null)
{
    $list = $model::query()
        ->with(
            'user', 'mefQuarter:id,name', 'mefProcessStatus:id,status_name,color',
            'organization:id,organization_name_en'
            )
        ->orderByDesc('id')
        ->when($request?->year, function ($query) use($request) {
            return $query->where('year', $request->year);
        })
        ->when($request?->quarter, function ($query) use($request) {
            return $query->where('mef_quarter_id', $request->quarter);
        })
        ->when($request?->organization_id, function ($query) use($request) {
            return $query->where('organization_id', $request->organization_id);
        })
        ->when($request?->status, function ($query) use($request) {
            return $query->where('mef_process_status_id', $request->status);
        })
        ->when(((int)Auth::user()->user_type != 1 && Auth::user()->user_role_id != 3), function ($query) {
            return $query->where('organization_id', Auth::user()->organization_id);
        })
        ->when(Auth::user()->user_role_id, function ($query) {
            //Provider
            if (Auth::user()->user_role_id == 1) {
                return $query->whereNot('assign_user_role', 7)->whereNot('assign_user_role', 2);
            }
        })
        ->get();

    return Datatables::of($list)
        ->editColumn('updated_at', function ($row) {
            return CommonFunction::formatLastUpdatedTime($row->updated_at);
        })
        ->editColumn('updated_by', function ($row) {
            return $row->user->username;
        })
        ->editColumn('organization_id', function ($row) {
            return $row->organization->organization_name_en;
        })
        ->editColumn('mef_quarter_id', function ($row) {
            return $row->mefQuarter->name;
        })
        ->editColumn('mef_process_status_id', function ($row) {
            $status =  '<span class="badge text-white" style="background-color: '.$row->mefProcessStatus->color.' " >'.$row->mefProcessStatus->status_name.'</span>';
            return $status;
        })
        ->addColumn('action', function ($row) use($prefix, $edit_permission, $approve, $checker) {
            $view_btn = '<a href="' . route($prefix.'.view', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-info btn-xs m-1"> Open </a>';
            $edit_btn = '';
            $shortfall_btn = '';
            if ($edit_permission && ($row->mef_process_status_id == '-1' || $row->mef_process_status_id == 5)) {
                $edit_btn = '<a href="' . route($prefix.'.edit', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Edit </a><br>';
            }
            $approve_btn = '';
            if ($approve && ($row->mef_process_status_id == 9 || $row->mef_process_status_id == 12)) {
                $approve_btn = '<a href="' . route($prefix.'.approve', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-primary btn-xs m-1"> Approve </a><br>';
                $shortfall_btn = '<a data-toggle="modal" data-target="#rejectModal" data-action="' . route($prefix.'.shortfall', ['id' => Encryption::encodeId($row->id)]) . '" class="open-rejectModal btn btn-flat btn-warning btn-xs m-1"> Review </a><br>';
            }
            $check_btn = '';
            if ($checker && (in_array($row->mef_process_status_id, [1, 11]))) {
                $check_btn = '<a href="' . route($prefix.'.check', ['id' => Encryption::encodeId($row->id)]) . '" class="btn btn-flat btn-success btn-xs m-1"> Check </a><br>';
                $shortfall_btn = '<a data-toggle="modal" data-target="#rejectModal" data-action="' . route($prefix.'.shortfall', ['id' => Encryption::encodeId($row->id)]) . '" class="open-rejectModal btn btn-flat btn-warning btn-xs m-1"> Shortfall </a><br>';
            }
            //Publisher
            if (Auth::user()->user_role_id == 3 && $row->mef_process_status_id == 25) {
                $isPublished = MefIndicatorMaster::query()->where('year', $row->year)->where('mef_quarter_id', $row->mef_quarter_id)->where('mef_process_status_id', 10)->where('is_approved', 1)->count();
                if (!$isPublished) {
                    $shortfall_btn = '<a data-toggle="modal" data-target="#rejectModal" data-action="' . route($prefix.'.shortfall', ['id' => Encryption::encodeId($row->id)]) . '" class="open-rejectModal btn btn-flat btn-warning btn-xs m-1"> Publisher Review </a><br>';
                }
            }

            return $view_btn . $edit_btn . $approve_btn . $check_btn . $shortfall_btn;
        })
        ->rawColumns(['action', 'mef_process_status_id'])
        ->make(true);
}

function mefShortfall($model, $id, $request, $service_id = null)
{
    try {
        DB::beginTransaction();
        $master_id = Encryption::decodeId($id);
        $master_data = $model::findOrFail($master_id);
        if (Auth::user()->user_role_id != 2 && Auth::user()->user_role_id != 3 && Auth::user()->user_role_id != 7) {
            Session::flash('error', "User role incorrect!");
            return false;
        }
        if (Auth::user()->user_role_id == 3) {
            $isPublished = MefIndicatorMaster::query()->where('year', $master_data->year)->where('mef_quarter_id', $master_data->mef_quarter_id)->where('mef_process_status_id', 10)->where('is_approved', 1)->count();
            if ($isPublished) {
                Session::flash('error', "Data already published!");
                return false;
            }
        }
        if (Auth::user()->user_role_id == 2 && $master_data->mef_process_status_id == 25) {
            Session::flash('error', "Data already approved!");
            return false;
        }elseif (Auth::user()->user_role_id == 7 && $master_data->mef_process_status_id == 9) {
            Session::flash('error', "Data already checked!");
            return false;
        }
        $master_data->reject_reason = $request->reject_reason??null;
        // Approver
        if (Auth::user()->user_role_id == 2){
            $master_data->mef_process_status_id = 11; // 11	Review
            $master_data->assign_user_role = 7; // Checker
        }
        // Checker
        elseif (Auth::user()->user_role_id == 7){
            $master_data->mef_process_status_id = 5; // Shortfall
            $master_data->assign_user_role = 1; // Provider
        }
        // Publisher
        elseif (Auth::user()->user_role_id == 3){
            $master_data->mef_process_status_id = 12; // Publisher Review
            $master_data->assign_user_role = 2; // Approver
            // source details tables status update
            $tables = $model::detailsTables();
            if (count($tables)) {
                foreach ($tables as $value) {
                    publisherReviewUpdateQuery($value, $master_id, $master_data->mef_quarter_id, $master_data->year);
                }
            }
        }
        $master_data->save();
        if ($service_id) {
            $mefShortfallRecord = new MefShortfallRecord();
            $mefShortfallRecord->service_id = $service_id;
            $mefShortfallRecord->master_id = $master_id;
            $mefShortfallRecord->reject_reason = $request->reject_reason??null;
            $mefShortfallRecord->save();
        }
        DB::commit();

        Session::flash('success', 'Data successfully Shortfall!');
        return true;

    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Error occurred in Helper@shortfall ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
        Session::flash('error', "Something went wrong [Helper-109]");
        return false;
    }
}

function mefLastApprovedDataInfo($source_table)
{
    return DB::table("$source_table")
        ->where('mef_process_status_id', 25)
        ->orderByDesc('id')
        ->first();
}

function eachSetFirstIndicatorIds()
{
    $cacheKey = 'each_set_first_indicator_ids';
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    } else {
        return Cache::rememberForever($cacheKey, function() {
            return MefIndicator::query()->groupBy('mef_set_id')->pluck('id')->except(0)->map(function (int $item, int $key) {
                return $item - 1;
            })->toArray();
        });
    }
    // return [6, 9, 12, 23, 35, 51, 65, 68, 98, 111, 119, 124, 136, 138, 140];
}

function usageDimensionSets()
{
    return [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
    ];
}

function qualityDimensionSets()
{
    return [
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
    ];
}

function approvedIndicatorYears()
{
    return MefIndicatorMaster::query()->where('is_approved', 1)->orderByDesc('year')->orderByDesc('mef_quarter_id')->get(['year', 'mef_quarter_id']);
}

function integratedIndexScore( $year, $quarter_id )
{
    if (!$quarter_id || !$year) {
        return null;
    }
    $data['approved_indicator_info'] = DB::table("mef_indicator_master_records")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('is_approved', 1)
        ->value('dimension_wise_info');

    $data['approved_goal_tracking_info'] = DB::table("goal_master_records")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('is_approved', 1)
        ->value('total_Weighted_score');


    return $data;

}

function interpretationCondition($totalScore)
{
    $integratedIndex = '';
    $interpretation = '';
    if ($totalScore >= 85 && $totalScore <= 100) {
        $integratedIndex = '85-100';
        $interpretation = 'Achieved-Right Progress';
    } elseif ($totalScore >= 70 && $totalScore <= 84) {
        $integratedIndex = '70-84';
        $interpretation = 'Partially Achieved-Slow Progress';
    } elseif ($totalScore >= 50 && $totalScore <= 69) {
        $integratedIndex = '50-69';
        $interpretation = 'Partially Achieved-Partial Action Adjustment Required';
    } elseif ($totalScore >= 0 && $totalScore <= 49) {
        $integratedIndex = '49 and below';
        $interpretation = 'Poor Progress-Action Adjustment Required';
    }

    return [
        'integratedIndex' => $integratedIndex,
        'interpretation' => $interpretation,
    ];
}

function scoreStatusChecking( $year, $quarter_id )
{
    if (!$quarter_id || !$year) {
        return null;
    }
    $res = DB::table("mef_published_score_records")
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->first();
    if ($res) {
        if ($res->is_active == 1) {
            return 'Active';
        }else{
            return 'Expired';
        }
    }else{
        return 'Inactive';
    }
}
