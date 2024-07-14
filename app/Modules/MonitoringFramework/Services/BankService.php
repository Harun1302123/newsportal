<?php
/**
 * Created by Harunur Rashid
 * Date: 24/10/2023
 * Time: 9:51 AM
 */
namespace App\Modules\MonitoringFramework\Services;

use App\Modules\MonitoringFramework\Models\Bank\MefBankMaster;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable1_1;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable1_2;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable1_3;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable1_4;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable1_5;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable10;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable2_1_1;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable2_1_2;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable2_2_1;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable2_2_2;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable3_1;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable3_2;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable3_3;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable4_1;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable4_2;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable5;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable6;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable7;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable8;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable9;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Bank\MefBankDetailsTable12;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankService
{

    public function store($request)
    {
        try {

 
            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefBankMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefBankMaster = MefBankMaster::findOrFail($master_id);
            } else {
                $mefBankMaster = new MefBankMaster();
            }
            $mefBankMaster->year = $request->year ?? null;
            $mefBankMaster->mef_quarter_id = $request->quarter ?? null;
            $mefBankMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefBankMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefBankMaster->mef_process_status_id = 1; // Submitted
            }
            $mefBankMaster->save();

            // Tab1.1
            foreach ($request->mef_bank_label_id_1_1 as $key => $item) {
                $detailsTableId_1_1 = $request->mef_bank_details_table_1_1_id[$key] ?? null;
                $table1_1 = MefBankDetailsTable1_1::findOrNew($detailsTableId_1_1); 
                $table1_1->master_id = $mefBankMaster->id;
                $table1_1->mef_bank_label_id = $item;
                $table1_1->male_rural = $request->male_rural_1_1[$key] ?? null;
                $table1_1->male_urban = $request->male_urban_1_1[$key] ?? null;
                $table1_1->male_total = ((int)$request->male_rural_1_1[$key] ?? 0) + ((int)$request->male_urban_1_1[$key] ?? 0);
                $table1_1->female_rural = $request->female_rural_1_1[$key] ?? null;
                $table1_1->female_urban = $request->female_urban_1_1[$key] ?? null;
                $table1_1->female_total = ((int)$request->female_rural_1_1[$key] ?? 0) + ((int)$request->female_urban_1_1[$key] ?? 0) ;
                $table1_1->others_rural = $request->others_rural_1_1[$key] ?? null;
                $table1_1->others_urban = $request->others_urban_1_1[$key] ?? null;
                $table1_1->others_total = ((int)$request->others_rural_1_1[$key] ?? 0) + ((int)$request->others_urban_1_1[$key] ?? 0) ;
                $table1_1->joint_rural = $request->joint_rural_1_1[$key] ?? null;
                $table1_1->joint_urban = $request->joint_urban_1_1[$key] ?? null;
                $table1_1->joint_total = ((int)$request->joint_rural_1_1[$key] ?? 0) + ((int)$request->joint_urban_1_1[$key] ?? 0) ;
                $table1_1->enterprise_rural = $request->enterprise_rural_1_1[$key] ?? null;
                $table1_1->enterprise_urban = $request->enterprise_urban_1_1[$key] ?? null;
                $table1_1->enterprise_total = ((int)$request->enterprise_rural_1_1[$key] ?? 0) + ((int)$request->enterprise_urban_1_1[$key] ?? 0) ;
                $table1_1->total_rural = ((int)$request->male_rural_1_1[$key] ?? 0) + ((int)$request->female_rural_1_1[$key] ?? 0) + ((int)$request->others_rural_1_1[$key] ?? 0) + ((int)$request->joint_rural_1_1[$key] ?? 0) + ((int)$request->enterprise_rural_1_1[$key] ?? 0);
                $table1_1->total_urban = ((int)$request->male_urban_1_1[$key] ?? 0) + ((int)$request->female_urban_1_1[$key] ?? 0) + ((int)$request->others_urban_1_1[$key] ?? 0) + ((int)$request->joint_urban_1_1[$key] ?? 0) + ((int)$request->enterprise_urban_1_1[$key] ?? 0);
                $table1_1->total_total = $table1_1->total_rural + $table1_1->total_urban ;
                $table1_1->save();
            }

            // Tab1.2
            foreach ($request->mef_bank_label_id_1_2 as $key => $item) {
                $detailsTableId_1_2 = $request->mef_bank_details_table_1_2_id[$key] ?? null;
                $table1_2 = MefBankDetailsTable1_2::findOrNew($detailsTableId_1_2);
                $table1_2->master_id = $mefBankMaster->id;
                $table1_2->mef_bank_label_id = $item;
                $table1_2->male_rural = $request->male_rural_1_2[$key] ?? null;
                $table1_2->male_urban = $request->male_urban_1_2[$key] ?? null;
                $table1_2->male_total = ((int)$request->male_rural_1_2[$key] ?? 0) + ((int)$request->male_urban_1_2[$key] ?? 0);
                $table1_2->female_rural = $request->female_rural_1_2[$key] ?? null;
                $table1_2->female_urban = $request->female_urban_1_2[$key] ?? null;
                $table1_2->female_total = ((int)$request->female_rural_1_2[$key] ?? 0) + ((int)$request->female_urban_1_2[$key] ?? 0) ;
                $table1_2->others_rural = $request->others_rural_1_2[$key] ?? null;
                $table1_2->others_urban = $request->others_urban_1_2[$key] ?? null;
                $table1_2->others_total = ((int)$request->others_rural_1_2[$key] ?? 0) + ((int)$request->others_urban_1_2[$key] ?? 0) ;
                $table1_2->joint_rural = $request->joint_rural_1_2[$key] ?? null;
                $table1_2->joint_urban = $request->joint_urban_1_2[$key] ?? null;
                $table1_2->joint_total = ((int)$request->joint_rural_1_2[$key] ?? 0) + ((int)$request->joint_urban_1_2[$key] ?? 0) ;
                $table1_2->enterprise_rural = $request->enterprise_rural_1_2[$key] ?? null;
                $table1_2->enterprise_urban = $request->enterprise_urban_1_2[$key] ?? null;
                $table1_2->enterprise_total = ((int)$request->enterprise_rural_1_2[$key] ?? 0) + ((int)$request->enterprise_urban_1_2[$key] ?? 0) ;
                $table1_2->total_rural = ((int)$request->male_rural_1_2[$key] ?? 0) + ((int)$request->female_rural_1_2[$key] ?? 0) + ((int)$request->others_rural_1_2[$key] ?? 0) + ((int)$request->joint_rural_1_2[$key] ?? 0) + ((int)$request->enterprise_rural_1_2[$key] ?? 0);
                $table1_2->total_urban = ((int)$request->male_urban_1_2[$key] ?? 0) + ((int)$request->female_urban_1_2[$key] ?? 0) + ((int)$request->others_urban_1_2[$key] ?? 0) + ((int)$request->joint_urban_1_2[$key] ?? 0) + ((int)$request->enterprise_urban_1_2[$key] ?? 0);
                $table1_2->total_total = $table1_2->total_rural + $table1_2->total_urban ;
                $table1_2->save();
            }

            // Tab1.3
            foreach ($request->mef_bank_label_id_1_3 as $key => $item) {
                $detailsTableId_1_3 = $request->mef_bank_details_table_1_3_id[$key] ?? null;
                $table1_3 = MefBankDetailsTable1_3::findOrNew($detailsTableId_1_3);
                $table1_3->master_id = $mefBankMaster->id;
                $table1_3->mef_bank_label_id = $item;
                $table1_3->male_rural = $request->male_rural_1_3[$key] ?? null;
                $table1_3->male_urban = $request->male_urban_1_3[$key] ?? null;
                $table1_3->male_total = ((int)$request->male_rural_1_3[$key] ?? 0) + ((int)$request->male_urban_1_3[$key] ?? 0);
                $table1_3->female_rural = $request->female_rural_1_3[$key] ?? null;
                $table1_3->female_urban = $request->female_urban_1_3[$key] ?? null;
                $table1_3->female_total = ((int)$request->female_rural_1_3[$key] ?? 0) + ((int)$request->female_urban_1_3[$key] ?? 0);
                $table1_3->others_rural = $request->others_rural_1_3[$key] ?? null;
                $table1_3->others_urban = $request->others_urban_1_3[$key] ?? null;
                $table1_3->others_total = ((int)$request->others_rural_1_3[$key] ?? 0) + ((int)$request->others_urban_1_3[$key] ?? 0);
                $table1_3->total_rural = ((int)$request->male_rural_1_3[$key] ?? 0) + ((int)$request->female_rural_1_3[$key] ?? 0) + ((int)$request->others_rural_1_3[$key] ?? 0);
                $table1_3->total_urban = ((int)$request->male_urban_1_3[$key] ?? 0) + ((int)$request->female_urban_1_3[$key] ?? 0) + ((int)$request->others_urban_1_3[$key] ?? 0);
                $table1_3->total_total = $table1_3->total_rural + $table1_3->total_urban ;
                $table1_3->save();
            }
            // Tab1.4
            foreach ($request->mef_bank_label_id_1_4 as $key => $item) {
                $detailsTableId_1_4 = $request->mef_bank_details_table_1_4_id[$key] ?? null;
                $table1_4 = MefBankDetailsTable1_4::findOrNew($detailsTableId_1_4);
                $table1_4->master_id = $mefBankMaster->id;
                $table1_4->mef_bank_label_id = $item;
                $table1_4->male_rural = $request->male_rural_1_4[$key] ?? null;
                $table1_4->male_urban = $request->male_urban_1_4[$key] ?? null;
                $table1_3->male_total = ((int)$request->male_rural_1_4[$key] ?? 0) + ((int)$request->male_urban_1_4[$key] ?? 0);
                $table1_4->female_rural = $request->female_rural_1_4[$key] ?? null;
                $table1_4->female_urban = $request->female_urban_1_4[$key] ?? null;
                $table1_4->female_total = ((int)$request->female_rural_1_4[$key] ?? 0) + ((int)$request->female_urban_1_4[$key] ?? 0) ;
                $table1_4->others_rural = $request->others_rural_1_4[$key] ?? null;
                $table1_4->others_urban = $request->others_urban_1_4[$key] ?? null;
                $table1_4->others_total = ((int)$request->others_rural_1_4[$key] ?? 0) + ((int)$request->others_urban_1_4[$key] ?? 0) ;
                $table1_4->joint_rural = $request->joint_rural_1_4[$key] ?? null;
                $table1_4->joint_urban = $request->joint_urban_1_4[$key] ?? null;
                $table1_4->joint_total = ((int)$request->joint_rural_1_4[$key] ?? 0) + ((int)$request->joint_urban_1_4[$key] ?? 0) ;
                $table1_4->enterprise_rural = $request->enterprise_rural_1_4[$key] ?? null;
                $table1_4->enterprise_urban = $request->enterprise_urban_1_4[$key] ?? null;
                $table1_4->enterprise_total = ((int)$request->enterprise_rural_1_4[$key] ?? 0) + ((int)$request->enterprise_urban_1_4[$key] ?? 0) ;
                $table1_4->total_rural = ((int)$request->male_rural_1_4[$key] ?? 0) + ((int)$request->female_rural_1_4[$key] ?? 0) + ((int)$request->others_rural_1_4[$key] ?? 0) + ((int)$request->joint_rural_1_4[$key] ?? 0) + ((int)$request->enterprise_rural_1_4[$key] ?? 0);
                $table1_4->total_urban = ((int)$request->male_urban_1_4[$key] ?? 0) + ((int)$request->female_urban_1_4[$key] ?? 0) + ((int)$request->others_urban_1_4[$key] ?? 0) + ((int)$request->joint_urban_1_4[$key] ?? 0) + ((int)$request->enterprise_urban_1_4[$key] ?? 0);
                $table1_4->total_total = $table1_4->total_rural + $table1_4->total_urban ;
                $table1_4->save();
            }

            // Tab1.5
            foreach ($request->mef_bank_label_id_1_5 as $key => $item) {
                $detailsTableId_1_5 = $request->mef_bank_details_table_1_5_id[$key] ?? null;
                $table1_5 = MefBankDetailsTable1_5::findOrNew($detailsTableId_1_5);
                $table1_5->master_id = $mefBankMaster->id;
                $table1_5->mef_bank_label_id = $item;
                $table1_5->male_rural = $request->male_rural_1_5[$key] ?? null;
                $table1_5->male_urban = $request->male_urban_1_5[$key] ?? null;
                $table1_5->male_total = ((int)$request->male_rural_1_5[$key] ?? 0) + ((int)$request->male_urban_1_5[$key] ?? 0);
                $table1_5->female_rural = $request->female_rural_1_5[$key] ?? null;
                $table1_5->female_urban = $request->female_urban_1_5[$key] ?? null;
                $table1_5->female_total = ((int)$request->female_rural_1_5[$key] ?? 0) + ((int)$request->female_urban_1_5[$key] ?? 0) ;
                $table1_5->others_rural = $request->others_rural_1_5[$key] ?? null;
                $table1_5->others_urban = $request->others_urban_1_5[$key] ?? null;
                $table1_5->others_total = ((int)$request->others_rural_1_5[$key] ?? 0) + ((int)$request->others_urban_1_5[$key] ?? 0) ;
                $table1_5->joint_rural = $request->joint_rural_1_5[$key] ?? null;
                $table1_5->joint_urban = $request->joint_urban_1_5[$key] ?? null;
                $table1_5->joint_total = ((int)$request->joint_rural_1_5[$key] ?? 0) + ((int)$request->joint_urban_1_5[$key] ?? 0) ;
                $table1_5->enterprise_rural = $request->enterprise_rural_1_5[$key] ?? null;
                $table1_5->enterprise_urban = $request->enterprise_urban_1_5[$key] ?? null;
                $table1_5->enterprise_total = ((int)$request->enterprise_rural_1_5[$key] ?? 0) + ((int)$request->enterprise_urban_1_5[$key] ?? 0) ;
                $table1_5->total_rural = ((int)$request->male_rural_1_5[$key] ?? 0) + ((int)$request->female_rural_1_5[$key] ?? 0) + ((int)$request->others_rural_1_5[$key] ?? 0) + ((int)$request->joint_rural_1_5[$key] ?? 0) + ((int)$request->enterprise_rural_1_5[$key] ?? 0);
                $table1_5->total_urban = ((int)$request->male_urban_1_5[$key] ?? 0) + ((int)$request->female_urban_1_5[$key] ?? 0) + ((int)$request->others_urban_1_5[$key] ?? 0) + ((int)$request->joint_urban_1_5[$key] ?? 0) + ((int)$request->enterprise_urban_1_5[$key] ?? 0);
                $table1_5->total_total = $table1_5->total_rural + $table1_5->total_urban ;
                $table1_5->save();
            }
            //Tab2.1.1
            $detailsTableId_2_1_1 = $request->mef_bank_details_table_2_1_1_id??null;
            $table2_1_1 = MefBankDetailsTable2_1_1::findOrNew($detailsTableId_2_1_1);
            $table2_1_1->master_id = $mefBankMaster->id;
            $table2_1_1->large_loan_rural = $request->large_loan_rural_2_1_1  ?? null;
            $table2_1_1->large_loan_urban = $request->large_loan_urban_2_1_1  ?? null;
            $table2_1_1->cottage_rural = $request->cottage_rural_2_1_1  ?? null;
            $table2_1_1->cottage_urban = $request->cottage_urban_2_1_1  ?? null;
            $table2_1_1->micro_rural = $request->micro_rural_2_1_1  ?? null;
            $table2_1_1->micro_urban = $request->micro_urban_2_1_1  ?? null;
            $table2_1_1->small_rural = $request->small_rural_2_1_1  ?? null;
            $table2_1_1->small_urban = $request->small_urban_2_1_1  ?? null;
            $table2_1_1->medium_rural = $request->medium_rural_2_1_1  ?? null;
            $table2_1_1->medium_urban = $request->medium_urban_2_1_1  ?? null;
            $table2_1_1->other_rural = $request->other_rural_2_1_1  ?? null;
            $table2_1_1->other_urban = $request->other_urban_2_1_1  ?? null;
            $table2_1_1->total_rural = (intval($request->large_loan_rural_2_1_1) ?? 0) + (intval($request->cottage_rural_2_1_1) ?? 0) 
                +(intval($request->micro_rural_2_1_1) ?? 0) +(intval($request->small_rural_2_1_1) ?? 0) 
                +(intval($request->medium_rural_2_1_1) ?? 0) + (intval($request->other_rural_2_1_1) ?? 0);
            $table2_1_1->total_urban = ((int)$request->large_loan_urban_2_1_1 ?? 0) + ((int)$request->cottage_urban_2_1_1 ?? 0) 
                +((int)$request->micro_urban_2_1_1 ?? 0) +((int)$request->small_urban_2_1_1 ?? 0) 
                +((int)$request->medium_urban_2_1_1 ?? 0) + ((int)$request->other_urban_2_1_1 ?? 0);
            $table2_1_1->total_total = $table2_1_1->total_rural + $table2_1_1->total_urban ;
            $table2_1_1->save();

            //Tab2.1.2
            foreach ($request->mef_bank_label_id_2_1_2 as $key => $item) {
                $detailsTableId_2_1_2= $request->mef_bank_details_table_2_1_2_id[$key] ?? null;
                $table2_1_2 = MefBankDetailsTable2_1_2::findOrNew($detailsTableId_2_1_2);
                $table2_1_2->master_id = $mefBankMaster->id;
                $table2_1_2->mef_bank_label_id = $item;
                $table2_1_2->male_rural = $request->male_rural_2_1_2[$key] ?? null;
                $table2_1_2->male_urban = $request->male_urban_2_1_2[$key] ?? null;
                $table2_1_2->male_total = ((int)$request->male_rural_2_1_2[$key] ?? 0) + ((int)$request->male_urban_2_1_2[$key] ?? 0);
                $table2_1_2->female_rural = $request->female_rural_2_1_2[$key] ?? null;
                $table2_1_2->female_urban = $request->female_urban_2_1_2[$key] ?? null;
                $table2_1_2->female_total = ((int)$request->female_rural_2_1_2[$key] ?? 0) + ((int)$request->female_urban_2_1_2[$key] ?? 0);
                $table2_1_2->others_rural = $request->others_rural_2_1_2[$key] ?? null;
                $table2_1_2->others_urban = $request->others_urban_2_1_2[$key] ?? null;
                $table2_1_2->others_total = ((int)$request->others_rural_2_1_2[$key] ?? 0) + ((int)$request->others_urban_2_1_2[$key] ?? 0);
                $table2_1_2->total_rural = ((int)$request->male_rural_2_1_2[$key] ?? 0) + ((int)$request->female_rural_2_1_2[$key] ?? 0) + ((int)$request->others_rural_2_1_2[$key] ?? 0);
                $table2_1_2->total_urban = ((int)$request->male_urban_2_1_2[$key] ?? 0) + ((int)$request->female_urban_2_1_2[$key] ?? 0) + ((int)$request->others_urban_2_1_2[$key] ?? 0);
                $table2_1_2->total_total = $table2_1_2->total_rural + $table2_1_2->total_urban ;
                $table2_1_2->save();
            }

            //Tab2.2.1
            $detailsTableId_2_2_1 = $request->mef_bank_details_table_2_2_1_id??null;
            $table2_2_1 = MefBankDetailsTable2_2_1::findOrNew($detailsTableId_2_2_1);
            $table2_2_1->master_id = $mefBankMaster->id;
            $table2_2_1->large_loan_rural = $request->large_loan_rural_2_2_1  ?? null;
            $table2_2_1->large_loan_urban = $request->large_loan_urban_2_2_1  ?? null;
            $table2_2_1->cottage_rural = $request->cottage_rural_2_2_1  ?? null;
            $table2_2_1->cottage_urban = $request->cottage_urban_2_2_1  ?? null;
            $table2_2_1->micro_rural = $request->micro_rural_2_2_1  ?? null;
            $table2_2_1->small_rural = $request->small_rural_2_2_1  ?? null;
            $table2_2_1->micro_urban = $request->micro_urban_2_2_1  ?? null;
            $table2_2_1->small_urban = $request->small_urban_2_2_1  ?? null;
            $table2_2_1->medium_rural = $request->medium_rural_2_2_1  ?? null;
            $table2_2_1->medium_urban = $request->medium_urban_2_2_1  ?? null;
            $table2_2_1->other_rural = $request->other_rural_2_2_1  ?? null;
            $table2_2_1->other_urban = $request->other_urban_2_2_1  ?? null;
            $table2_2_1->total_rural = ((int)$request->large_loan_rural_2_2_1 ?? 0) + ((int)$request->cottage_rural_2_2_1 ?? 0) + ((int)$request->micro_rural_2_2_1 ?? 0) + ((int)$request->small_rural_2_2_1 ?? 0) + ((int)$request->medium_rural_2_2_1 ?? 0) + ((int)$request->other_rural_2_2_1 ?? 0);
            $table2_2_1->total_urban =  ((int)$request->large_loan_urban_2_2_1 ?? 0) + ((int)$request->cottage_urban_2_2_1 ?? 0) + ((int)$request->micro_urban_2_2_1 ?? 0) + ((int)$request->small_urban_2_2_1 ?? 0) + ((int)$request->medium_urban_2_2_1 ?? 0) + ((int)$request->other_urban_2_2_1 ?? 0);
            $table2_2_1->total_total = intval($table2_2_1->total_rural) + intval($table2_2_1->total_urban) ;
            $table2_2_1->save();


            //Tab2.2.2
            foreach ($request->mef_bank_label_id_2_2_2 as $key => $item) {
                $detailsTableId_2_2_2 = $request->mef_bank_details_table_2_2_2_id[$key] ?? null;
                $table2_2_2 = MefBankDetailsTable2_2_2::findOrNew($detailsTableId_2_2_2);
                $table2_2_2->master_id = $mefBankMaster->id;
                $table2_2_2->mef_bank_label_id = $item;
                $table2_2_2->male_rural = $request->male_rural_2_2_2[$key] ?? null;
                $table2_2_2->male_urban = $request->male_urban_2_2_2[$key] ?? null;
                $table2_2_2->male_total = ((int)$request->male_rural_2_2_2[$key] ?? 0) + ((int)$request->male_urban_2_2_2[$key] ?? 0);
                $table2_2_2->female_rural = $request->female_rural_2_2_2[$key] ?? null;
                $table2_2_2->female_urban = $request->female_urban_2_2_2[$key] ?? null;
                $table2_2_2->female_total = ((int)$request->female_rural_2_2_2[$key] ?? 0) + ((int)$request->female_urban_2_2_2[$key] ?? 0);
                $table2_2_2->others_rural = $request->others_rural_2_2_2[$key] ?? null;
                $table2_2_2->others_urban = $request->others_urban_2_2_2[$key] ?? null;
                $table2_2_2->others_total = ((int)$request->others_rural_2_2_2[$key] ?? 0) + ((int)$request->others_urban_2_2_2[$key] ?? 0);
                $table2_2_2->total_rural = ((int)$request->male_rural_2_2_2[$key] ?? 0) + ((int)$request->female_rural_2_2_2[$key] ?? 0) + ((int)$request->others_rural_2_2_2[$key] ?? 0);
                $table2_2_2->total_urban = ((int)$request->male_urban_2_2_2[$key] ?? 0) + ((int)$request->female_urban_2_2_2[$key] ?? 0) + ((int)$request->others_urban_2_2_2[$key] ?? 0);
                $table2_2_2->total_total = intval($table2_2_2->total_rural) + intval($table2_2_2->total_urban) ;
                $table2_2_2->save();
            }

            //Tab3.1
            foreach ($request->mef_bank_label_id_3_1 as $key => $item) {
                $detailsTableId_3_1= $request->mef_bank_details_table_3_1_id[$key] ?? null;
                $table3_1 = MefBankDetailsTable3_1::findOrNew($detailsTableId_3_1);
                $table3_1->master_id = $mefBankMaster->id;
                $table3_1->mef_bank_label_id = $item;
                $table3_1->male_rural = $request->male_rural_3_1[$key] ?? null;
                $table3_1->male_urban = $request->male_urban_3_1[$key] ?? null;
                $table3_1->male_total = ((int)$request->male_rural_3_1[$key] ?? 0) + ((int)$request->male_urban_3_1[$key] ?? 0);
                $table3_1->female_rural = $request->female_rural_3_1[$key] ?? null;
                $table3_1->female_urban = $request->female_urban_3_1[$key] ?? null;
                $table3_1->female_total = ((int)$request->female_rural_3_1[$key] ?? 0) + ((int)$request->female_urban_3_1[$key] ?? 0);
                $table3_1->others_rural = $request->others_rural_3_1[$key] ?? null;
                $table3_1->others_urban = $request->others_urban_3_1[$key] ?? null;
                $table3_1->others_total = ((int)$request->others_rural_3_1[$key] ?? 0) + ((int)$request->others_urban_3_1[$key] ?? 0);
                $table3_1->total_rural = ((int)$request->male_rural_3_1[$key] ?? 0) + ((int)$request->female_rural_3_1[$key] ?? 0) + ((int)$request->others_rural_3_1[$key] ?? 0);
                $table3_1->total_urban = ((int)$request->male_urban_3_1[$key] ?? 0) + ((int)$request->female_urban_3_1[$key] ?? 0) + ((int)$request->others_urban_3_1[$key] ?? 0);
                $table3_1->total_total = $table3_1->total_rural + $table3_1->total_urban ;
                $table3_1->save();
            }

            //Tab3.2
            foreach ($request->mef_bank_label_id_3_2 as $key => $item) {
                $detailsTableId_3_2 = $request->mef_bank_details_table_3_2_id[$key] ?? null;
                $table3_2 = MefBankDetailsTable3_2::findOrNew($detailsTableId_3_2);
                $table3_2->master_id = $mefBankMaster->id;
                $table3_2->mef_bank_label_id = $item;
                $table3_2->male_rural = $request->male_rural_3_2[$key] ?? null;
                $table3_2->male_urban = $request->male_urban_3_2[$key] ?? null;
                $table3_2->male_total = ((int)$request->male_rural_3_2[$key] ?? 0) + ((int)$request->male_urban_3_2[$key] ?? 0);
                $table3_2->female_rural = $request->female_rural_3_2[$key] ?? null;
                $table3_2->female_urban = $request->female_urban_3_2[$key] ?? null;
                $table3_2->female_total = ((int)$request->female_rural_3_2[$key] ?? 0) + ((int)$request->female_urban_3_2[$key] ?? 0);
                $table3_2->others_rural = $request->others_rural_3_2[$key] ?? null;
                $table3_2->others_urban = $request->others_urban_3_2[$key] ?? null;
                $table3_2->others_total = ((int)$request->others_rural_3_2[$key] ?? 0) + ((int)$request->others_urban_3_2[$key] ?? 0);
                $table3_2->joint_rural = $request->joint_rural_3_2[$key] ?? null;
                $table3_2->joint_urban = $request->joint_urban_3_2[$key] ?? null;
                $table3_2->joint_total = ((int)$request->joint_rural_3_2[$key] ?? 0) + ((int)$request->joint_urban_3_2[$key] ?? 0) ;
                $table3_2->enterprise_rural = $request->enterprise_rural_3_2[$key] ?? null;
                $table3_2->enterprise_urban = $request->enterprise_urban_3_2[$key] ?? null;
                $table3_2->enterprise_total = ((int)$request->enterprise_rural_3_2[$key] ?? 0) + ((int)$request->enterprise_urban_3_2[$key] ?? 0);
                $table3_2->total_rural = ((int)$request->male_rural_3_2[$key] ?? 0) + ((int)$request->female_rural_3_2[$key] ?? 0) + ((int)$request->others_rural_3_2[$key] ?? 0) + ((int)$request->joint_rural_3_2[$key] ?? 0) + ((int)$request->enterprise_rural_3_2[$key] ?? 0);
                $table3_2->total_urban = ((int)$request->male_urban_3_2[$key] ?? 0) + ((int)$request->female_urban_3_2[$key] ?? 0) + ((int)$request->others_urban_3_2[$key] ?? 0) + ((int)$request->joint_urban_3_2[$key] ?? 0) + ((int)$request->enterprise_urban_3_2[$key] ?? 0);
                $table3_2->total_total = $table3_2->total_rural + $table3_2->total_urban ;
                $table3_2->save();
            }

            //Tab3.3
            foreach ($request->mef_bank_label_id_3_3 as $key => $item) {
                $detailsTableId_3_3 = $request->mef_bank_details_table_3_3_id[$key] ?? null;
                $table3_3 = MefBankDetailsTable3_3::findOrNew($detailsTableId_3_3);
                $table3_3->master_id = $mefBankMaster->id;
                $table3_3->mef_bank_label_id = $item;
                $table3_3->male_rural = $request->male_rural_3_3[$key] ?? null;
                $table3_3->male_urban = $request->male_urban_3_3[$key] ?? null;
                $table3_3->male_total = ((int)$request->male_rural_3_3[$key] ?? 0) + ((int)$request->male_urban_3_3[$key] ?? 0);
                $table3_3->female_rural = $request->female_rural_3_3[$key] ?? null;
                $table3_3->female_urban = $request->female_urban_3_3[$key] ?? null;
                $table3_3->female_total = ((int)$request->female_rural_3_3[$key] ?? 0) + ((int)$request->female_urban_3_3[$key] ?? 0);
                $table3_3->others_rural = $request->others_rural_3_3[$key] ?? null;
                $table3_3->others_urban = $request->others_urban_3_3[$key] ?? null;
                $table3_3->others_total = ((int)$request->others_rural_3_3[$key] ?? 0) + ((int)$request->others_urban_3_3[$key] ?? 0);
                $table3_3->joint_rural = $request->joint_rural_3_3[$key] ?? null;
                $table3_3->joint_urban = $request->joint_urban_3_3[$key] ?? null;
                $table3_3->joint_total = ((int)$request->joint_rural_3_3[$key] ?? 0) + ((int)$request->joint_urban_3_3[$key] ?? 0) ;
                $table3_3->enterprise_rural = $request->enterprise_rural_3_3[$key] ?? null;
                $table3_3->enterprise_urban = $request->enterprise_urban_3_3[$key] ?? null;
                $table3_3->enterprise_total = ((int)$request->enterprise_rural_3_3[$key] ?? 0) + ((int)$request->enterprise_urban_3_3[$key] ?? 0);
                $table3_3->total_rural = ((int)$request->male_rural_3_3[$key] ?? 0) + ((int)$request->female_rural_3_3[$key] ?? 0) + ((int)$request->others_rural_3_3[$key] ?? 0) + ((int)$request->joint_rural_3_3[$key] ?? 0) + ((int)$request->enterprise_rural_3_3[$key] ?? 0);
                $table3_3->total_urban = ((int)$request->male_urban_3_3[$key] ?? 0) + ((int)$request->female_urban_3_3[$key] ?? 0) + ((int)$request->others_urban_3_3[$key] ?? 0) + ((int)$request->joint_urban_3_3[$key] ?? 0) + ((int)$request->enterprise_urban_3_3[$key] ?? 0);
                $table3_3->total_total = $table3_3->total_rural + $table3_3->total_urban ;
                $table3_3->save();
            }

            //Tab4.1
            foreach ($request->mef_bank_label_id_4_1 as $key => $item) {
                $detailsTableId_4_1 = $request->mef_bank_details_table_4_1_id[$key] ?? null;
                $table4_1 = MefBankDetailsTable4_1::findOrNew($detailsTableId_4_1);
                $table4_1->master_id = $mefBankMaster->id;
                $table4_1->mef_bank_label_id = $item;
                $table4_1->male_rural = $request->male_rural_4_1[$key] ?? null;
                $table4_1->male_urban = $request->male_urban_4_1[$key] ?? null;
                $table4_1->male_total = ((int)$request->male_rural_4_1[$key] ?? 0) + ((int)$request->male_urban_4_1[$key] ?? 0);
                $table4_1->female_rural = $request->female_rural_4_1[$key] ?? null;
                $table4_1->female_urban = $request->female_urban_4_1[$key] ?? null;
                $table4_1->female_total = ((int)$request->female_rural_4_1[$key] ?? 0) + ((int)$request->female_urban_4_1[$key] ?? 0);
                $table4_1->others_rural = $request->others_rural_4_1[$key] ?? null;
                $table4_1->others_urban = $request->others_urban_4_1[$key] ?? null;
                $table4_1->others_total = ((int)$request->others_rural_4_1[$key] ?? 0) + ((int)$request->others_urban_4_1[$key] ?? 0);
                $table4_1->total_rural = ((int)$request->male_rural_4_1[$key] ?? 0) + ((int)$request->female_rural_4_1[$key] ?? 0) + ((int)$request->others_rural_4_1[$key] ?? 0);
                $table4_1->total_urban = ((int)$request->male_urban_4_1[$key] ?? 0) + ((int)$request->female_urban_4_1[$key] ?? 0) + ((int)$request->others_urban_4_1[$key] ?? 0);
                $table4_1->total_total = $table4_1->total_rural + $table4_1->total_urban ;
                $table4_1->save();
            }

            //Tab4.2
            foreach ($request->mef_bank_label_id_4_2 as $key => $item) {
                $detailsTableId_4_2 = $request->mef_bank_details_table_4_2_id[$key] ?? null;
                $table4_2 = MefBankDetailsTable4_2::findOrNew($detailsTableId_4_2);
                $table4_2->master_id = $mefBankMaster->id;
                $table4_2->mef_bank_label_id = $item;
                $table4_2->db_male_rural = $request->db_male_rural_4_2[$key] ?? null;
                $table4_2->db_male_urban = $request->db_male_urban_4_2[$key] ?? null;
                $table4_2->db_female_rural = $request->db_female_rural_4_2[$key] ?? null;
                $table4_2->db_female_urban = $request->db_female_urban_4_2[$key] ?? null;
                $table4_2->db_others_rural = $request->db_others_rural_4_2[$key] ?? null;
                $table4_2->db_others_urban = $request->db_others_urban_4_2[$key] ?? null;
                $table4_2->db_total_rural = ((int)$request->db_male_rural_4_2[$key] ?? 0) + ((int)$request->db_female_rural_4_2[$key] ?? 0) + ((int)$request->db_others_rural_4_2[$key] ?? 0);
                $table4_2->db_total_urban = ((int)$request->db_male_urban_4_2[$key] ?? 0) + ((int)$request->db_female_urban_4_2[$key] ?? 0) + ((int)$request->db_others_urban_4_2[$key] ?? 0);
                $table4_2->db_total_total =  $table4_2->db_total_rural + $table4_2->db_total_urban;
                $table4_2->sd_male_rural = $request->sd_male_rural_4_2[$key] ?? null;
                $table4_2->sd_male_urban = $request->sd_male_urban_4_2[$key] ?? null;
                $table4_2->sd_female_rural = $request->sd_female_rural_4_2[$key] ?? null;
                $table4_2->sd_female_urban = $request->sd_female_urban_4_2[$key] ?? null;
                $table4_2->sd_others_rural = $request->sd_others_rural_4_2[$key] ?? null;
                $table4_2->sd_others_urban = $request->sd_others_urban_4_2[$key] ?? null;
                $table4_2->sd_total_rural = ((int)$request->sd_male_rural_4_2[$key] ?? 0) + ((int)$request->sd_female_rural_4_2[$key] ?? 0) + ((int)$request->sd_others_rural_4_2[$key] ?? 0);
                $table4_2->sd_total_urban = ((int)$request->sd_male_urban_4_2[$key] ?? 0) + ((int)$request->sd_female_urban_4_2[$key] ?? 0) + ((int)$request->sd_others_urban_4_2[$key] ?? 0);
                $table4_2->sd_total_total =  $table4_2->sd_total_rural + $table4_2->sd_total_urban ;
                $table4_2->save();
            }

            //Tab5
            foreach ($request->mef_bank_label_id_5 as $key => $item) {
                $detailsTableId_5 = $request->mef_bank_details_table_5_id[$key] ?? null;
                $table5 = MefBankDetailsTable5::findOrNew($detailsTableId_5);
                $table5->master_id = $mefBankMaster->id;
                $table5->mef_bank_label_id = $item;
                $table5->u_standard_male = $request->u_standard_male_5[$key] ?? null;
                $table5->u_standard_female = $request->u_standard_female_5[$key] ?? null;
                $table5->u_standard_others = $request->u_standard_others_5[$key] ?? null;
                $table5->u_standard_joint = $request->u_standard_joint_5[$key] ?? null;
                $table5->u_standard_enterprise = $request->u_standard_enterprise_5[$key] ?? null;
                $table5->u_standard_total = ((int)$request->u_standard_male_5[$key] ?? 0) +((int)$request->u_standard_female_5[$key] ?? 0) +((int)$request->u_standard_others_5[$key] ?? 0) +((int)$request->u_standard_joint_5[$key] ?? 0) +((int)$request->u_standard_enterprise_5[$key] ?? 0) ;
                $table5->u_sma_male = $request->u_sma_male_5[$key] ?? null;
                $table5->u_sma_female = $request->u_sma_female_5[$key] ?? null;
                $table5->u_sma_others = $request->u_sma_others_5[$key] ?? null;
                $table5->u_sma_joint = $request->u_sma_joint_5[$key] ?? null;
                $table5->u_sma_enterprise = $request->u_sma_enterprise_5[$key] ?? null;
                $table5->u_sma_total = ((int)$request->u_sma_male_5[$key] ?? 0) +((int)$request->u_sma_female_5[$key] ?? 0) +((int)$request->u_sma_others_5[$key] ?? 0)  +((int)$request->u_sma_joint_5[$key] ?? 0) +((int)$request->u_sma_enterprise_5[$key] ?? 0) ;
                $table5->c_ss_male = $request->c_ss_male_5[$key] ?? null;
                $table5->c_ss_female = $request->c_ss_female_5[$key] ?? null;
                $table5->c_ss_others = $request->c_ss_others_5[$key] ?? null;
                $table5->c_ss_joint = $request->c_ss_joint_5[$key] ?? null;
                $table5->c_ss_enterprise = $request->c_ss_enterprise_5[$key] ?? null;
                $table5->c_ss_total = ((int)$request->c_ss_male_5[$key] ?? 0) +((int)$request->c_ss_female_5[$key] ?? 0) +((int)$request->c_ss_others_5[$key] ?? 0) +((int)$request->c_ss_joint_5[$key] ?? 0) +((int)$request->c_ss_enterprise_5[$key] ?? 0) ;
                $table5->c_df_male = $request->c_df_male_5[$key] ?? null;
                $table5->c_df_female = $request->c_df_female_5[$key] ?? null;
                $table5->c_df_others = $request->c_df_others_5[$key] ?? null;
                $table5->c_df_joint = $request->c_df_joint_5[$key] ?? null;
                $table5->c_df_enterprise = $request->c_df_enterprise_5[$key] ?? null;
                $table5->c_df_total = ((int)$request->c_df_male_5[$key] ?? 0) +((int)$request->c_df_female_5[$key] ?? 0) +((int)$request->c_df_others_5[$key] ?? 0) +((int)$request->c_df_joint_5[$key] ?? 0) +((int)$request->c_df_enterprise_5[$key] ?? 0) ;
                $table5->c_bl_male = $request->c_bl_male_5[$key] ?? null;
                $table5->c_bl_female = $request->c_bl_female_5[$key] ?? null;
                $table5->c_bl_others = $request->c_bl_others_5[$key] ?? null;
                $table5->c_bl_joint = $request->c_bl_joint_5[$key] ?? null;
                $table5->c_bl_enterprise = $request->c_bl_enterprise_5[$key] ?? null;
                $table5->c_bl_total = ((int)$request->c_bl_male_5[$key] ?? 0) +((int)$request->c_bl_female_5[$key] ?? 0) +((int)$request->c_bl_others_5[$key] ?? 0) +((int)$request->c_bl_joint_5[$key] ?? 0) +((int)$request->c_bl_enterprise_5[$key] ?? 0) ;
                $table5->total_male =((int)$request->u_standard_male_5[$key] ?? 0) + ((int)$request->u_sma_male_5[$key] ?? 0) + ((int)$request->c_ss_male_5[$key] ?? 0) 
                    + ((int)$request->c_df_male_5[$key] ?? 0) + ((int)$request->c_bl_male_5[$key] ?? 0) ;
                $table5->total_female =((int)$request->u_standard_female_5[$key] ?? 0) + ((int)$request->u_sma_female_5[$key] ?? 0) 
                    + ((int)$request->c_ss_female_5[$key] ?? 0) + ((int)$request->c_df_female_5[$key] ?? 0) + ((int)$request->c_bl_female_5[$key] ?? 0);
                $table5->total_others =((int)$request->u_standard_others_5[$key] ?? 0) + ((int)$request->u_sma_others_5[$key] ?? 0) 
                    + ((int)$request->c_ss_others_5[$key] ?? 0) + ((int)$request->c_df_others_5[$key] ?? 0) + ((int)$request->c_bl_others_5[$key] ?? 0);
                $table5->total_joint =((int)$request->u_standard_joint_5[$key] ?? 0) + ((int)$request->u_sma_joint_5[$key] ?? 0) 
                    + ((int)$request->c_ss_joint_5[$key] ?? 0) + ((int)$request->c_df_joint_5[$key] ?? 0) + ((int)$request->c_bl_joint_5[$key] ?? 0);
                $table5->total_enterprise =((int)$request->u_standard_enterprise_5[$key] ?? 0) + ((int)$request->u_sma_enterprise_5[$key] ?? 0) 
                    + ((int)$request->c_ss_enterprise_5[$key] ?? 0) + ((int)$request->c_df_enterprise_5[$key] ?? 0) + ((int)$request->c_bl_enterprise_5[$key] ?? 0);
                $table5->total_total = $table5->total_male + $table5->total_female +  $table5->total_others +  $table5->total_joint + $table5->total_enterprise;
                $table5->save();
            }

            //Tab6
            $detailsTableId_6 = $request->mef_bank_details_table_6_id??null;
            $table6 = MefBankDetailsTable6::findOrNew($detailsTableId_6);
            $table6->master_id = $mefBankMaster->id;
            $table6->nauib_male_rural = $request->nauib_male_rural_6  ?? null;;
            $table6->nauib_male_urban = $request->nauib_male_urban_6  ?? null;;
            $table6->nauib_female_rural = $request->nauib_female_rural_6  ?? null;;
            $table6->nauib_female_urban = $request->nauib_female_urban_6  ?? null;;
            $table6->nauib_others_rural = $request->nauib_others_rural_6  ?? null;;
            $table6->nauib_others_urban = $request->nauib_others_urban_6  ?? null;;
            $table6->nauib_joint_rural = $request->nauib_joint_rural_6  ?? null;;
            $table6->nauib_joint_urban = $request->nauib_joint_urban_6  ?? null;;
            $table6->dcu_male_rural = $request->dcu_male_rural_6  ?? null;;
            $table6->dcu_male_urban = $request->dcu_male_urban_6  ?? null;;
            $table6->dcu_female_rural = $request->dcu_female_rural_6  ?? null;;
            $table6->dcu_female_urban = $request->dcu_female_urban_6  ?? null;;
            $table6->dcu_others_rural = $request->dcu_others_rural_6  ?? null;;
            $table6->dcu_others_urban = $request->dcu_others_urban_6  ?? null;;
            $table6->dcu_joint_rural = $request->dcu_joint_rural_6  ?? null;;
            $table6->dcu_joint_urban = $request->dcu_joint_urban_6  ?? null;;
            $table6->ccu_male_rural = $request->ccu_male_rural_6  ?? null;;
            $table6->ccu_male_urban = $request->ccu_male_urban_6  ?? null;;
            $table6->ccu_female_rural = $request->ccu_female_rural_6  ?? null;;
            $table6->ccu_female_urban = $request->ccu_female_urban_6  ?? null;;
            $table6->ccu_others_rural = $request->ccu_others_rural_6  ?? null;;
            $table6->ccu_others_urban = $request->ccu_others_urban_6  ?? null;;
            $table6->pcu_male_rural = $request->pcu_male_rural_6  ?? null;;
            $table6->pcu_male_urban = $request->pcu_male_urban_6  ?? null;;
            $table6->pcu_female_rural = $request->pcu_female_rural_6  ?? null;;
            $table6->pcu_female_urban = $request->pcu_female_urban_6  ?? null;;
            $table6->pcu_others_rural = $request->pcu_others_rural_6  ?? null;;
            $table6->pcu_others_urban = $request->pcu_others_urban_6  ?? null;;
            $table6->save();

            //Tab7
            $detailsTableId_7 = $request->mef_bank_details_table_7_id??null;
            $table7 = MefBankDetailsTable7::findOrNew($detailsTableId_7);
            $table7->master_id = $mefBankMaster->id;
            $table7->nb_rural = $request->nb_rural_7  ?? null;
            $table7->nb_urban = $request->nb_urban_7  ?? null;
            $table7->nb_total = ((int)$request->nb_rural_7 ?? 0) + ((int)$request->nb_urban_7 ?? 0) ;
            $table7->nob_rural = $request->nob_rural_7  ?? null;
            $table7->nob_urban = $request->nob_urban_7  ?? null;
            $table7->nob_total = ((int)$request->nob_rural_7 ?? 0) + ((int)$request->nob_urban_7 ?? 0) ;
            $table7->nsb_rural = $request->nsb_rural_7  ?? null;
            $table7->nsb_urban = $request->nsb_urban_7  ?? null;
            $table7->nsb_total = ((int)$request->nsb_rural_7 ?? 0) + ((int)$request->nsb_urban_7 ?? 0) ;
            $table7->na_rural = $request->na_rural_7  ?? null;
            $table7->na_urban = $request->na_urban_7  ?? null;
            $table7->na_total = ((int)$request->na_rural_7 ?? 0) + ((int)$request->na_urban_7 ?? 0) ;
            $table7->ncdm_rural = $request->ncdm_rural_7  ?? null;
            $table7->ncdm_urban = $request->ncdm_urban_7  ?? null;
            $table7->ncdm_total = ((int)$request->ncdm_rural_7 ?? 0) + ((int)$request->ncdm_urban_7 ?? 0) ;
            $table7->ncrm_rural = $request->ncrm_rural_7  ?? null;
            $table7->ncrm_urban = $request->ncrm_urban_7  ?? null;
            $table7->ncrm_total = ((int)$request->ncrm_rural_7 ?? 0) + ((int)$request->ncrm_urban_7 ?? 0) ;
            $table7->npos_rural = $request->npos_rural_7  ?? null;
            $table7->npos_urban = $request->npos_urban_7  ?? null;
            $table7->npos_total = ((int)$request->npos_rural_7 ?? 0) + ((int)$request->npos_urban_7 ?? 0) ;
            $table7->save();

            //Tab8
            foreach ($request->mef_bank_label_id_8 as $key => $item) {
                $detailsTableId_8 = $request->mef_bank_details_table_8_id[$key] ?? null;
                $table8 = MefBankDetailsTable8::findOrNew($detailsTableId_8);
                $table8->master_id = $mefBankMaster->id;
                $table8->mef_bank_label_id = $item;
                $table8->qrct_rural = $request->qrct_rural_8[$key] ?? null;
                $table8->qrct_urban = $request->qrct_urban_8[$key] ?? null;
                $table8-> qrct_total = ((int)$request->qrct_rural_8[$key] ?? 0) + ((int)$request->qrct_urban_8[$key] ?? 0) ;
                $table8->bqrt_rural = $request->bqrt_rural_8[$key] ?? null;
                $table8->bqrt_urban = $request->bqrt_urban_8[$key] ?? null;
                $table8->bqrt_total = ((int)$request->bqrt_rural_8[$key] ?? 0) + ((int)$request->bqrt_urban_8[$key] ?? 0) ;
                $table8->save();
            }

            //Tab9
            foreach ($request->mef_bank_label_id_9 as $key => $item) {
                $detailsTableId_9 = $request->mef_bank_details_table_9_id[$key] ?? null;
                $table9 = MefBankDetailsTable9::findOrNew($detailsTableId_9);
                $table9->master_id = $mefBankMaster->id;
                $table9->mef_bank_label_id = $item;
                $table9->nt_male_rural = $request->nt_male_rural[$key] ?? null;
                $table9->nt_male_urban = $request->nt_male_urban[$key] ?? null;
                $table9->nt_male_total = ((int)$request->nt_male_rural[$key] ?? 0) + ((int)$request->nt_male_urban[$key]  ?? 0) ;
                $table9->nt_female_rural = $request->nt_female_rural[$key] ?? null;
                $table9->nt_female_urban = $request->nt_female_urban[$key] ?? null;
                $table9->nt_female_total = ((int)$request->nt_female_rural[$key] ?? 0) + ((int)$request->nt_female_urban[$key] ?? 0) ;
                $table9->nt_institutional_rural = $request->nt_institutional_rural[$key] ?? null;
                $table9->nt_institutional_urban = $request->nt_institutional_urban[$key] ?? null;
                $table9->nt_institutional_total = ((int)$request->nt_institutional_rural[$key] ?? 0) + ((int)$request->nt_institutional_urban[$key] ?? 0) ;
                $table9->nt_total_rural = ((int)$request->nt_male_rural[$key] ?? 0) + ((int)$request->nt_female_rural[$key] ?? 0) + ((int)$request->nt_institutional_rural[$key] ?? 0);
                $table9->nt_total_urban = ((int)$request->nt_male_urban[$key]  ?? 0) + ((int)$request->nt_female_urban[$key] ?? 0) + ((int)$request->nt_institutional_urban[$key] ?? 0) ;
                $table9->nt_total_total = $table9->nt_total_rural + $table9->nt_total_urban;
                $table9->at_male_rural = $request->at_male_rural[$key] ?? null;
                $table9->at_male_urban = $request->at_male_urban[$key] ?? null;
                $table9->at_male_total = ((int)$request->at_male_rural[$key] ?? 0) + ((int)$request->at_male_urban[$key] ?? 0) ;
                $table9->at_female_rural = $request->at_female_rural[$key] ?? null;
                $table9->at_female_urban = $request->at_female_urban[$key] ?? null;
                $table9->at_female_total = ((int)$request->at_female_rural[$key] ?? 0) + ((int)$request->at_female_urban[$key] ?? 0) ;
                $table9->at_institutional_rural = $request->at_institutional_rural[$key] ?? null;
                $table9->at_institutional_urban = $request->at_institutional_urban[$key] ?? null;
                $table9->at_institutional_total = ((int)$request->at_institutional_rural[$key] ?? 0) + ((int)$request->at_institutional_urban[$key] ?? 0) ;
                $table9->at_total_rural = ((int)$request->at_male_rural[$key] ?? 0) + ((int)$request->at_female_rural[$key] ?? 0) + ((int)$request->at_institutional_rural[$key] ?? 0);
                $table9->at_total_urban = ((int)$request->at_male_urban[$key] ?? 0) + ((int)$request->at_female_urban[$key] ?? 0) + ((int)$request->at_institutional_urban[$key] ?? 0);
                $table9->at_total_total = $table9->at_total_rural + $table9->at_total_urban;
                $table9->save();
            }

            //Tab10
            $detailsTableId_10 = $request->mef_bank_details_table_10_id??null; 
            $table10 = MefBankDetailsTable10::findOrNew($detailsTableId_10); 
            $table10->master_id = $mefBankMaster->id;
            $table10->nflpo_dhaka = $request->nflpo_dhaka_10  ?? null;
            $table10->nflpo_others_region = $request->nflpo_others_region_10  ?? null;
            $table10->nflpo_total = ((int)$request->nflpo_dhaka_10 ?? 0) + ((int)$request->nflpo_others_region_10 ?? 0);
            $table10->np_male = $request->np_male_10  ?? null;
            $table10->np_female = $request->np_female_10  ?? null;
            $table10->np_others = $request->np_others_10  ?? null;
            $table10->np_total = ((int)$request->np_male_10 ?? 0) + ((int)$request->np_female_10 ?? 0) + ((int)$request->np_others_10 ?? 0);

            $table10->save();

            //Tab12
            $detailsTableId12 = $request->mef_bank_details_table_12_id??null; 
            $table12 = MefBankDetailsTable12::findOrNew($detailsTableId12); 
            $table12->master_id = $mefBankMaster->id;
            $table12->complaints_received = $request->complaints_received  ?? null;
            $table12->complaints_resolved = $request->complaints_resolved  ?? null;
            $table12->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table12->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in BankService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefBankService-101]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data['mefBankDetailsTable1_1'] = MefBankDetailsTable1_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable1_2'] = MefBankDetailsTable1_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable1_3'] = MefBankDetailsTable1_3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable1_4'] = MefBankDetailsTable1_4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable1_5'] = MefBankDetailsTable1_5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable2_1_1'] = MefBankDetailsTable2_1_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefBankDetailsTable2_1_2'] = MefBankDetailsTable2_1_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable2_2_1'] = MefBankDetailsTable2_2_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefBankDetailsTable2_2_2'] = MefBankDetailsTable2_2_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable3_1'] = MefBankDetailsTable3_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable3_2'] = MefBankDetailsTable3_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable3_3'] = MefBankDetailsTable3_3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable4_1'] = MefBankDetailsTable4_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable4_2'] = MefBankDetailsTable4_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable5'] = MefBankDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable6'] = MefBankDetailsTable6::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefBankDetailsTable7'] = MefBankDetailsTable7::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefBankDetailsTable8'] = MefBankDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable9'] = MefBankDetailsTable9::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable10'] = MefBankDetailsTable10::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            // $data['mefBankDetailsTable11_1'] = MefBankDetailsTable11_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            // $data['mefBankDetailsTable11_2'] = MefBankDetailsTable11_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            // $data['mefBankDetailsTable11_3'] = MefBankDetailsTable11_3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefBankDetailsTable12'] = MefBankDetailsTable12::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in BankService@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefBankService-101]");
            return redirect()->back();
        }
    }

}