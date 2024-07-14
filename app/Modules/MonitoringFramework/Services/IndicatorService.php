<?php
/**
 * Created by Harunur Rashid
 * Date: 24/10/2023
 * Time: 9:51 AM
 */
namespace App\Modules\MonitoringFramework\Services;

use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Indicator\MefIndicatorDetailsRecord;
use App\Modules\MonitoringFramework\Models\Indicator\MefIndicatorMaster;
use App\Modules\MonitoringFramework\Models\Indicator\MefIndicatorSetDetailsRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class IndicatorService
{

    public function store($request)
    {   
        try {

            $isExist = MefIndicatorMaster::query()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->where('mef_process_status_id', 10)->where('is_approved', 1)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already published for this year and quarter!");
                return redirect()->back();
            }

            $dimensionWiseInfo = [
                "usage_allocated_score_total" => $request->usage_allocated_score_total ?? null,
                "usage_achieved_score_total" => $request->usage_achieved_score_total ?? null,
                "access_allocated_score_total" => $request->access_allocated_score_total ?? null,
                "access_achieved_score_total" => $request->access_achieved_score_total ?? null,
                "quality_allocated_score_total" => $request->quality_allocated_score_total ?? null,
                "quality_achieved_score_total" => $request->quality_achieved_score_total ?? null,
            ];
            
            DB::beginTransaction();
            
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefIndicatorMaster = MefIndicatorMaster::findOrFail($master_id);
            } else {
                $mefIndicatorMaster = new MefIndicatorMaster();
            }
            $mefIndicatorMaster->year = $request->year ?? null;
            $mefIndicatorMaster->mef_quarter_id = $request->quarter ?? null;
            $mefIndicatorMaster->mef_process_status_id = 10;	// Published
            $mefIndicatorMaster->is_approved = 1; // Approved
            $mefIndicatorMaster->dimension_wise_info = json_encode($dimensionWiseInfo);
            $mefIndicatorMaster->save();

            foreach ($request->indicator_id as $key => $item) {
                $detailsTableId1 = $request->details_table_id_2[$key] ?? null;
                $detailsTable1 = MefIndicatorDetailsRecord::findOrNew($detailsTableId1);
                $detailsTable1->master_id = $mefIndicatorMaster->id;
                $detailsTable1->mef_indicator_id = $item;
                $detailsTable1->mef_set_id = $request->indicator_set_id[$key] ?? null;
                $detailsTable1->previous_value = $request->previous_value[$key] ?? null;
                $detailsTable1->current_value = $request->current_value[$key] ?? null;
                $detailsTable1->changes_percentage = $request->changes_percentage[$key] ?? null;
                $detailsTable1->score = $request->score[$key] ?? null;
                $detailsTable1->save();
            }

            foreach ($request->set_id as $key => $item) {
                if ($key == 0) {
                    $setWiseInfo = [
                        "total_current_value" => $request->set_a_total_current_value,
                        "total_population_by_census" => $request->set_a_total_population_by_census,
                        "total_accounts_population" => $request->set_a_total_accounts_population,
                        "benchmark" => $request->set_a_benchmark,
                        "maximum_score" => $request->set_a_maximum_score,
                        "achieved_score" => $request->set_a_achieved_score,
                    ];
                }else{
                    $setWiseInfo = [
                        "total_score" => $request->total_score[$key-1] ?? null,
                        "maximum_score" => $request->maximum_score[$key-1] ?? null,
                        "allocated_score" => $request->allocated_score[$key-1] ?? null,
                        "achieved_score" => $request->achieved_score[$key-1] ?? null,
                    ];
                }

                $detailsTableId2 = $request->details_table_id_2[$key] ?? null;
                $detailsTable2 = MefIndicatorSetDetailsRecord::findOrNew($detailsTableId2);
                $detailsTable2->master_id = $mefIndicatorMaster->id;
                $detailsTable2->mef_set_id = $item ?? null;
                $detailsTable2->set_wise_info = json_encode($setWiseInfo);
                $detailsTable2->save();
            }

            DB::commit();

            Session::flash('success', 'Data save successfully!');


        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in IndicatorService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefIndicatorService-101]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport()
    {
        try {
            
        } catch (\Exception $e) {
            Log::error("Error occurred in IndicatorService@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefIndicatorService-101]");
            return redirect()->back();
        }
    }

}