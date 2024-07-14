<?php

namespace App\Modules\MonitoringFramework\Services;


use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisDetailsTable1;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisDetailsTable2;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisDetailsTable3;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisDetailsTable4;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisDetailsTable8;
use App\Modules\MonitoringFramework\Models\Cmis\MefCmisMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CmisService
{

    public function store($request)
    {
        try {

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefCmisMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $MefCmisMaster = MefCmisMaster::findOrFail($master_id);
            } else {
                $MefCmisMaster = new MefCmisMaster();
            }
            $MefCmisMaster->year = $request->year ?? null;
            $MefCmisMaster->mef_quarter_id = $request->quarter ?? null;
            $MefCmisMaster->organization_id = Auth::user()->organization_id ?? null;
            $MefCmisMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $MefCmisMaster->mef_process_status_id = 1; // Submitted
            }
            $MefCmisMaster->save();

            // 1. Account Related Information
            if (isset($request->district_id)) {
                foreach ($request->district_id as $key => $item) {
                    $detailsTableid = $request->mef_cmis_details_table_1_id[$key] ?? null;
                    $table1 = MefCmisDetailsTable1::findOrNew($detailsTableid);
                    $table1->master_id = $MefCmisMaster->id;
                    $table1->district_id = $item;
                    $table1->division_id = $request->division_id[$key] ?? null;

                    $table1->nbo_accounts_male = $request->nbo_accounts_male[$key] ?? null;
                    $table1->nbo_accounts_female = $request->nbo_accounts_female[$key] ?? null;
                    $table1->nbo_accounts_others = $request->nbo_accounts_others[$key] ?? null;
                    $table1->nbo_accounts_institutional = $request->nbo_accounts_institutional[$key] ?? null;
                    $table1->nbo_total = intval($request->nbo_accounts_male[$key] ?? 0) + intval($request->nbo_accounts_female[$key] ?? 0) + intval($request->nbo_accounts_others[$key] ?? 0) + intval($request->nbo_accounts_institutional[$key] ?? 0);
                    $table1->save();
                }
            }

            // 2. Automation Related Information
            $detailsTable2Id = $request->mef_cmis_details_table_2_id ?? null;
            $table2 = MefCmisDetailsTable2::findOrNew($detailsTable2Id);
            $table2->master_id = $MefCmisMaster->id;
            $table2->number_of_boauma_male = $request->number_of_boauma_male ?? null;
            $table2->number_of_boauma_female = $request->number_of_boauma_female ?? null;
            $table2->number_of_boauma_others = $request->number_of_boauma_others ?? null;
            $table2->number_of_boauma_institutional = $request->number_of_boauma_institutional ?? null;
            $table2->total = intval($request->number_of_boauma_male ?? 0) + intval($request->number_of_boauma_female ?? 0) + intval($request->number_of_boauma_others ?? 0) + intval($request->number_of_boauma_institutional ?? 0);

            $table2->save();



            // 3. CMI Related Information

            if (isset($request->mef_cmis_table3_label_id)) {
                foreach ($request->mef_cmis_table3_label_id as $key => $item) {
                    $detailsTable3id = $request->mef_cmis_details_table_3_id[$key] ?? null;
                    $table3 = MefCmisDetailsTable3::findOrNew($detailsTable3id);
                    $table3->master_id = $MefCmisMaster->id;
                    $table3->mef_cmis_label_id = $item;
                    $table3->number_of_cmis = $request->number_of_cmis[$key] ?? null;
                    $table3->number_of_branch = $request->number_of_branch[$key] ?? null;
                    $table3->number_of_online_branch = $request->number_of_online_branch[$key] ?? null;
                    $table3->save();
                }
            }

            // 4. Financial Literacy Programmes (During the quarter)

            $detailsTable4Id = $request->mef_cmis_details_table_4_id ?? null;
            $table4 = MefCmisDetailsTable4::findOrNew($detailsTable4Id);
            $table4->master_id = $MefCmisMaster->id;
            $table4->number_of_flp_organize_dhaka = $request->number_of_flp_organize_dhaka ?? null;
            $table4->number_of_flp_organize_other_region = $request->number_of_flp_organize_other_region ?? null;
            $table4->nflpo_total = intval($request->number_of_flp_organize_dhaka ?? 0) + intval($request->number_of_flp_organize_other_region ?? 0);
            $table4->number_of_participation_male = $request->number_of_participation_male ?? null;
            $table4->number_of_participation_female = $request->number_of_participation_female ?? null;
            $table4->number_of_participation_others = $request->number_of_participation_others ?? null;
            $table4->nop_total = intval($request->number_of_participation_male ?? 0) + intval($request->number_of_participation_female ?? 0) + intval($request->number_of_participation_others ?? 0);
            $table4->save();

            $detailsTableId8 = $request->mef_cmis_details_table_8_id??null; 
            $table8 = MefCmisDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $MefCmisMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in CmisService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefCmisMaster-102]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data = [];
            $data['MefCmisDetailsTable1'] = MefCmisDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['MefCmisDetailsTable2'] = MefCmisDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['MefCmisDetailsTable3'] = MefCmisDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['MefCmisDetailsTable4'] = MefCmisDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['MefCmisDetailsTable8'] = MefCmisDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in CmisService@summary_report ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefCmisMaster-105]");
            return redirect()->back();
        }
    }
}
