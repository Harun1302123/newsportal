<?php
/**
 * Created by Harunur Rashid
 * Date: 24/10/2023
 * Time: 9:51 AM
 */
namespace App\Modules\MonitoringFramework\Services;

use App\Libraries\Encryption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceMaster;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable1;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable2;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable3;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable4;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable5;
use App\Modules\MonitoringFramework\Models\Insurance\MefInsuranceDetailsTable8;

class InsuranceService
{

    public function store($request)
    {

        try {

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefInsuranceMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefInsuranceMaster = MefInsuranceMaster::findOrFail($master_id);
            } else {
                $mefInsuranceMaster = new MefInsuranceMaster();
            }

            $mefInsuranceMaster->year = $request->year ?? null;
            $mefInsuranceMaster->mef_quarter_id = $request->quarter ?? null;
            $mefInsuranceMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefInsuranceMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefInsuranceMaster->mef_process_status_id = 1; // Submitted
            }
            $mefInsuranceMaster->save();

            // MefInsuranceDetailsTable1
            foreach ($request->district_id as $key => $item) {
                $detailsTableId = $request->mef_insurance_details_table_1_id[$key] ?? null;
                $table1 = MefInsuranceDetailsTable1::findOrNew($detailsTableId); // edit page theke MefInsuranceDetailsTable1 id pass korte hobe
                $table1->master_id = $mefInsuranceMaster->id;
                $table1->district_id = $item;
                $table1->division_id = $request->division_id[$key] ?? null;
                $table1->tlip_male = $request->tlip_male[$key] ?? null;
                $table1->tlip_female = $request->tlip_female[$key] ?? null;
                $table1->tlip_others = $request->tlip_others[$key] ?? null;
                $table1->tlip_total =  intval($request->tlip_male[$key]) + intval($request->tlip_female[$key]) + intval($request->tlip_others[$key]);
                $table1->mip_male = $request->mip_male[$key] ?? null;
                $table1->mip_female = $request->mip_female[$key] ?? null;
                $table1->mip_others = $request->mip_others[$key] ?? null;
                $table1->mip_total =  intval($request->mip_male[$key]) + intval($request->mip_female[$key]) + intval($request->mip_others[$key]);
                $table1->hp_male = $request->hp_male[$key] ?? null;
                $table1->hp_female = $request->hp_female[$key] ?? null;
                $table1->hp_others = $request->hp_others[$key] ?? null;
                $table1->hp_total =  intval($request->hp_male[$key]) + intval($request->hp_female[$key]) + intval($request->hp_others[$key]);
                $table1->ap_total_number = $request->ap_total_number[$key] ?? null;
                $table1->nfp_total_number = $request->nfp_total_number[$key] ?? null;
                $table1->total_ip =  intval($request->ap_total_number[$key] ?? 0) + intval($request->nfp_total_number[$key] ?? 0);
                $table1->save();
            }

            // MefInsuranceDetailsTable2
            foreach ($request->district_id_1_1 as $key => $item) {
                $detailsTable2Id = $request->mef_insurance_details_table_2_id[$key] ?? null;
                $table2 = MefInsuranceDetailsTable2::findOrNew($detailsTable2Id);
                $table2->master_id = $mefInsuranceMaster->id;
                $table2->district_id = $item;
                $table2->division_id = $request->division_id_1_1[$key] ?? null;
                $table2->tlip_male = $request->tlip_male_1_1[$key] ?? null;
                $table2->tlip_female = $request->tlip_female_1_1[$key] ?? null;
                $table2->tlip_others = $request->tlip_others_1_1[$key] ?? null;
                $table2->tlip_total =  intval($request->tlip_male_1_1[$key] ?? 0) + intval($request->tlip_female_1_1[$key] ?? 0) + intval($request->tlip_others_1_1[$key] ?? 0);
                $table2->mip_male = $request->mip_male_1_1[$key] ?? null;
                $table2->mip_female = $request->mip_female_1_1[$key] ?? null;
                $table2->mip_others = $request->mip_others_1_1[$key] ?? null;
                $table2->mip_total =  intval($request->mip_male_1_1[$key] ?? 0) + intval($request->mip_female_1_1[$key] ?? 0) + intval($request->mip_others_1_1[$key] ?? 0);
                $table2->hp_male = $request->hp_male_1_1[$key] ?? null;
                $table2->hp_female = $request->hp_female_1_1[$key] ?? null;
                $table2->hp_others = $request->hp_others_1_1[$key] ?? null;
                $table2->hp_total =  intval($request->hp_male_1_1[$key] ?? 0) + intval($request->hp_female_1_1[$key] ?? 0) + intval($request->hp_others_1_1[$key] ?? 0);
                $table2->ap_total_number = $request->ap_total_number_1_1[$key] ?? null;
                $table2->nfp_total_number = $request->nfp_total_number_1_1[$key] ?? null;
                $table2->total_ip =  intval($request->ap_total_number_1_1[$key] ?? 0) + intval($request->nfp_total_number_1_1[$key] ?? 0);
                $table2->save();
            }

            // MefInsuranceDetailsTable3
            $detailsTable3Id = $request->mef_insurance_details_table_3_id ?? null;
            $table3 = MefInsuranceDetailsTable3::findOrNew($detailsTable3Id);
            $table3->master_id = $mefInsuranceMaster->id;
            $table3->nphuibs_male = $request->nphuibs_male ?? null;
            $table3->nphuibs_female = $request->nphuibs_female ?? null;
            $table3->nphuibs_others = $request->nphuibs_others ?? null;
            $table3->nphuibs_total = intval($request->nphuibs_male) + intval($request->nphuibs_female) + intval($request->nphuibs_others);
            $table3->nphppt_mfs_male = $request->nphppt_mfs_male ?? null;
            $table3->nphppt_mfs_female = $request->nphppt_mfs_female ?? null;
            $table3->nphppt_mfs_others = $request->nphppt_mfs_others ?? null;
            $table3->nphppt_mfs_total = intval($request->nphppt_mfs_male) + intval($request->nphppt_mfs_female) + intval($request->nphppt_mfs_others);
            $table3->nphppt_bank_male = $request->nphppt_bank_male ?? null;
            $table3->nphppt_bank_female = $request->nphppt_bank_female ?? null;
            $table3->nphppt_bank_others = $request->nphppt_bank_others ?? null;
            $table3->nphppt_bank_total = intval($request->nphppt_bank_male) + intval($request->nphppt_bank_female) + intval($request->nphppt_bank_others);
            $table3->save();

            // MefInsuranceDetailsTable4
            $detailsTable4Id = $request->mef_insurance_details_table_4_id ?? null;
            $table4 = MefInsuranceDetailsTable4::findOrNew($detailsTable4Id);
            $table4->master_id = $mefInsuranceMaster->id;
            $table4->number_of_branch = $request->number_of_branch ?? null;
            $table4->online_branch = $request->online_branch ?? null;
            $table4->save();

            //MefInsuranceDetailsTable5
            $detailsTable5Id = $request->mef_insurance_details_table_5_id ?? null;
            $table5 = MefInsuranceDetailsTable5::findOrNew($detailsTable5Id);
            $table5->master_id = $mefInsuranceMaster->id;
            $table5->number_of_flpo_dhaka = $request->nflpo_dhaka ?? null;
            $table5->number_of_flpo_other_regions = $request->nflpo_others ?? null;
            $table5->number_of_flpo_total_regions = intval($request->nflpo_dhaka) + intval($request->nflpo_others);
            $table5->number_of_participants_male = $request->np_male ?? null;
            $table5->number_of_participants_female = $request->np_female ?? null;
            $table5->number_of_participants_others = $request->np_others ?? null;
            $table5->number_of_participants_total = intval($request->np_male) + intval($request->np_female) + intval($request->np_others);
            $table5->save();

            $detailsTableId8 = $request->mef_insurance_details_table_8_id??null; 
            $table8 = MefInsuranceDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $mefInsuranceMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in InsuranceService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefInsuranceService-101]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data['mefInsuranceDetailsTable1'] = mefInsuranceDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefInsuranceDetailsTable2'] = mefInsuranceDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefInsuranceDetailsTable3'] = mefInsuranceDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefInsuranceDetailsTable4'] = mefInsuranceDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefInsuranceDetailsTable5'] = mefInsuranceDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefInsuranceDetailsTable8'] = MefInsuranceDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            return $data;
            
        } catch (\Exception $e) {
            Log::error("Error occurred in InsuranceService@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefInsuranceService-101]");
            return redirect()->back();
        }
    }

}