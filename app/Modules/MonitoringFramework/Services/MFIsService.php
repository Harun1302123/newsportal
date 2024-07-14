<?php
/**
 * Created by Harunur Rashid
 * Date: 24/10/2023
 * Time: 9:51 AM
 */
namespace App\Modules\MonitoringFramework\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable1;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable2;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable3;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable4;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable5;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable6;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable7;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisDetailsTable8;
use App\Modules\MonitoringFramework\Models\Mfis\MefMfisMaster;

class MFIsService
{

    public function store($request)
    {

        try {
            
            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefMfisMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            // MefMfisMaster
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefMfisMaster = MefMfisMaster::findOrFail($master_id);
            } else {
                $mefMfisMaster = new MefMfisMaster();
            }
            $mefMfisMaster->year = $request->year ?? null;
            $mefMfisMaster->mef_quarter_id = $request->quarter ?? null;
            $mefMfisMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefMfisMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefMfisMaster->mef_process_status_id = 1; // Submitted
            }
            $mefMfisMaster->save();

            // MefMfisDetailsTable1
            foreach ($request->district_id as $key => $item) {
                $detailsTableId = $request->mef_mfis_details_table_1_id[$key] ?? null;
                $table1 = MefMfisDetailsTable1::findOrNew($detailsTableId);
                $table1->master_id = $mefMfisMaster->id;
                $table1->district_id = $item;
                $table1->division_id = $request->division_id[$key] ?? null;
                $table1->nta_male = $request->nta_male[$key] ?? null;
                $table1->nta_female = $request->nta_female[$key] ?? null;
                $table1->nta_others = $request->nta_others[$key] ?? null;
                $table1->nta_total =  (intval($table1->nta_male) + intval($table1->nta_female) + intval($table1->nta_others));
                $table1->nba_male = $request->nba_male[$key] ?? null;
                $table1->nba_female = $request->nba_female[$key] ?? null;
                $table1->nba_others = $request->nba_others[$key] ?? null;
                $table1->nba_total =  (intval($table1->nba_male) + intval($table1->nba_female) + intval($table1->nba_others))??0;
                $table1->ntla_male = $request->ntla_male[$key] ?? null;
                $table1->ntla_female = $request->ntla_female[$key] ?? null;
                $table1->ntla_others = $request->ntla_others[$key] ?? null;
                $table1->ntla_total =  (intval($table1->ntla_male) + intval($table1->ntla_female) + intval($table1->ntla_others))??0;
                $table1->blla_male = $request->blla_male[$key] ?? null;
                $table1->blla_female = $request->blla_female[$key] ?? null;
                $table1->blla_others = $request->blla_others[$key] ?? null;
                $table1->blla_total =  (intval($table1->blla_male)+ intval($table1->blla_female) + intval($table1->blla_others));
                $table1->save();
            }

            // MefMfisDetailsTable2
            foreach ($request->district_id_1_1 as $key => $item) {
                $detailsTable2Id = $request->mef_mfis_details_table_1_1_id[$key] ?? null;
                $table2 = MefMfisDetailsTable2::findOrNew($detailsTable2Id);
                $table2->master_id = $mefMfisMaster->id;
                $table2->district_id = $item;
                $table2->division_id = $request->division_id_1_1[$key] ?? null;
                $table2->bta_male = $request->bta_male[$key] ?? null;
                $table2->bta_female = $request->bta_female[$key] ?? null;
                $table2->bta_others = $request->bta_others[$key] ?? null;
                $table2->bta_total =  intval($request->bta_male[$key]??0) + intval($request->bta_female[$key]??0) + intval($request->bta_others[$key]??0);
                $table2->bsa_male = $request->bsa_male[$key] ?? null;
                $table2->bsa_female = $request->bsa_female[$key] ?? null;
                $table2->bsa_others = $request->bsa_others[$key] ?? null;
                $table2->bsa_total =  intval($request->bsa_male[$key]??0) + intval($request->bsa_female[$key]??0) + intval($request->bsa_others[$key]??0);
                $table2->obtla_male = $request->obtla_male[$key] ?? null;
                $table2->obtla_female = $request->obtla_female[$key] ?? null;
                $table2->obtla_others = $request->obtla_others[$key] ?? null;
                $table2->obtla_total =  intval($request->obtla_male[$key]??0) + intval($request->obtla_female[$key]??0) + intval($request->obtla_others[$key]??0);
                $table2->oblla_male = $request->oblla_male[$key] ?? null;
                $table2->oblla_female = $request->oblla_female[$key] ?? null;
                $table2->oblla_others = $request->oblla_others[$key] ?? null;
                $table2->oblla_total =  intval($request->oblla_male[$key]??0) + intval($request->oblla_female[$key]??0) + intval($request->oblla_others[$key]??0);
                $table2->save();
            }

            // MefMfisDetailsTable3
            $detailsTable3Id = $request->mef_mfis_details_table_3_id ?? null;
            $table3 = MefMfisDetailsTable3::findOrNew($detailsTable3Id);
            $table3->master_id = $mefMfisMaster->id;
            $table3->naui_male = $request->naui_male ?? null;
            $table3->naui_female = $request->naui_female?? null;
            $table3->naui_others = $request->naui_others?? null;
            $table3->naui_total = intval($request->naui_male??0) + intval($request->naui_female??0) + intval($request->naui_others??0);
            $table3->nbrl_male = $request->nbrl_male?? null;
            $table3->nbrl_female = $request->nbrl_female?? null;
            $table3->nbrl_others = $request->nbrl_others?? null;
            $table3->nbrl_total = intval($request->nbrl_male??0) + intval($request->nbrl_female??0) + intval($request->nbrl_others??0);
            $table3->nbpi_male = $request->nbpi_male?? null;
            $table3->nbpi_female = $request->nbpi_female?? null;
            $table3->nbpi_others = $request->nbpi_others?? null;
            $table3->nbpi_total = intval($request->nbpi_male??0) + intval($request->nbpi_female??0) + intval($request->nbpi_others??0);
            $table3->save();

            // MefMfisDetailsTable4
            $detailsTable4Id = $request->mef_mfis_details_table_4_id ?? null;
            $table4 = MefMfisDetailsTable4::findOrNew($detailsTable4Id);
            $table4->master_id = $mefMfisMaster->id;
            $table4->number_of_mfis = $request->number_of_mfis ?? null;
            $table4->number_of_branch = $request->number_of_branch?? null;
            $table4->number_of_online_branch = $request->number_of_online_branch?? null;
            $table4->save();

            // MefMfisDetailsTable5
            foreach ($request->mef_mfis_label_id_5 as $key => $item) {
                $detailsTable5Id = $request->mef_mfis_details_table_5_id[$key] ?? null;
                $table5 = MefMfisDetailsTable5::findOrNew($detailsTable5Id);
                $table5->master_id = $mefMfisMaster->id;
                $table5->mef_mfis_label_id = $item;
                $table5->unclassified = $request->unclassified[$key] ?? null;
                $table5->classified = $request->classified[$key] ?? null;
                $table5->save();
            }

            // MefMfisDetailsTable6
            $detailsTable6Id = $request->mef_mfis_details_table_6_id ?? null;
            $table6 = MefMfisDetailsTable6::findOrNew($detailsTable6Id);
            $table6->master_id = $mefMfisMaster->id;
            $table6->mef_mfis_label_id = $request->mef_mfis_label_id_6??null;
            $table6->nt_male = $request->nt_male ?? null;
            $table6->nt_female = $request->nt_female ?? null;
            $table6->nt_others = $request->nt_others ?? null;
            $table6->nt_total = intval($request->nt_male??0) + intval($request->nt_female??0) + intval($request->nt_others??0);
            $table6->at_male = $request->at_male ?? null;
            $table6->at_female = $request->at_female ?? null;
            $table6->at_others = $request->at_others ?? null;
            $table6->at_total = intval($request->at_male??0) + intval($request->at_female??0) + intval($request->at_others??0);
            $table6->save();

            // MefMfisDetailsTable7
            $detailsTable7Id = $request->mef_mfis_details_table_7_id ?? null;
            $table7 = MefMfisDetailsTable7::findOrNew($detailsTable7Id);
            $table7->master_id = $mefMfisMaster->id;
            $table7->nflpo_dhaka = $request->nflpo_dhaka ?? null;
            $table7->nflpo_others = $request->nflpo_others?? null;
            $table7->nflpo_total = intval($request->nflpo_dhaka??0) + intval($request->nflpo_others??0);
            $table7->np_male = $request->np_male?? null;
            $table7->np_female = $request->np_female?? null;
            $table7->np_others = $request->np_others?? null;
            $table7->np_total = intval($request->np_male??0) + intval($request->np_female??0) + intval($request->np_others??0);
            $table7->save();

            $detailsTableId8 = $request->mef_mfis_details_table_8_id??null; 
            $table8 = MefMfisDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $mefMfisMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MFIsService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MFIsService-101]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data['mefMfisDetailsTable1'] = MefMfisDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfisDetailsTable2'] = MefMfisDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfisDetailsTable3'] = MefMfisDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfisDetailsTable4'] = MefMfisDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfisDetailsTable5'] = MefMfisDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfisDetailsTable6'] = MefMfisDetailsTable6::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfisDetailsTable7'] = MefMfisDetailsTable7::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfisDetailsTable8'] = MefMfisDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in MFIsService@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MFIsService-101]");
            return redirect()->back();
        }
    }

}