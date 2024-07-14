<?php
/**
 * Created by Harunur Rashid
 * Date: 24/6/2023
 * Time: 9:51 AM
 */
namespace App\Modules\MonitoringFramework\Services;

use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisMaster;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable1_1;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable1_2;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable1_3;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable1_4;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable1_5;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable2_1_1;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable2_1_2;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable2_2_1;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable2_2_2;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable3;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable4;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable5;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable6;
use App\Modules\MonitoringFramework\Models\Nbfis\MefNbfisDetailsTable8;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Libraries\Encryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NbfisService
{

    public function store($request)
    {
        try {

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefNbfisMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefNbfisMaster = MefNbfisMaster::findOrFail($master_id);
            } else {
                $mefNbfisMaster = new MefNbfisMaster();
            }
            $mefNbfisMaster->year = $request->year ?? null;
            $mefNbfisMaster->mef_quarter_id = $request->quarter ?? null;
            $mefNbfisMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefNbfisMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefNbfisMaster->mef_process_status_id = 1; // Submitted
            }
            $mefNbfisMaster->save();

            // Tab1.1
            foreach ($request->mef_nbfis_label_id_1_1 as $key => $item) {
                $detailsTableId_1_1 = $request->mef_nbfis_details_table_1_1_id[$key] ?? null;
                $table1_1 = MefNbfisDetailsTable1_1::findOrNew($detailsTableId_1_1); //item change hoye table er main id asbe
                $table1_1->master_id = $mefNbfisMaster->id;
                $table1_1->mef_nbfis_label_id = $item;
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
            foreach ($request->mef_nbfis_label_id_1_2 as $key => $item) {
                $detailsTableId_1_2 = $request->mef_nbfis_details_table_1_2_id[$key] ?? null;
                $table1_2 = MefNbfisDetailsTable1_2::findOrNew($detailsTableId_1_2);
                $table1_2->master_id = $mefNbfisMaster->id;
                $table1_2->mef_nbfis_label_id = $item;
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
            foreach ($request->mef_nbfis_label_id_1_3 as $key => $item) {
                $detailsTableId_1_3 = $request->mef_nbfis_details_table_1_3_id[$key] ?? null;
                $table1_3 = MefNbfisDetailsTable1_3::findOrNew($detailsTableId_1_3);
                $table1_3->master_id = $mefNbfisMaster->id;
                $table1_3->mef_nbfis_label_id = $item;
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
            foreach ($request->mef_nbfis_label_id_1_4 as $key => $item) {
                $detailsTableId_1_4 = $request->mef_nbfis_details_table_1_4_id[$key] ?? null;
                $table1_4 = MefNbfisDetailsTable1_4::findOrNew($detailsTableId_1_4);
                $table1_4->master_id = $mefNbfisMaster->id;
                $table1_4->mef_nbfis_label_id = $item;
                $table1_4->male_rural = $request->male_rural_1_4[$key] ?? null;
                $table1_4->male_urban = $request->male_urban_1_4[$key] ?? null;
                $table1_4->male_total = ((int)$request->male_rural_1_4[$key] ?? 0) + ((int)$request->male_urban_1_4[$key] ?? 0);
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
            foreach ($request->mef_nbfis_label_id_1_5 as $key => $item) {
                $detailsTableId_1_5 = $request->mef_nbfis_details_table_1_5_id[$key] ?? null;
                $table1_5 = MefNbfisDetailsTable1_5::findOrNew($detailsTableId_1_5);
                $table1_5->master_id = $mefNbfisMaster->id;
                $table1_5->mef_nbfis_label_id = $item;
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
            $detailsTableId_2_1_1 = $request->mef_nbfis_details_table_2_1_1_id??null;
            $table2_1_1 = MefNbfisDetailsTable2_1_1::findOrNew($detailsTableId_2_1_1);
            $table2_1_1->master_id = $mefNbfisMaster->id;
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
            foreach ($request->mef_nbfis_label_id_2_1_2 as $key => $item) {
                $detailsTableId_2_1_2= $request->mef_nbfis_details_table_2_1_2_id[$key] ?? null;
                $table2_1_2 = MefNbfisDetailsTable2_1_2::findOrNew($detailsTableId_2_1_2);
                $table2_1_2->master_id = $mefNbfisMaster->id;
                $table2_1_2->mef_nbfis_label_id = $item;
                $table2_1_2->male_rural = $request->male_rural_2_1_2[$key] ?? null;
                $table2_1_2->male_urban = $request->male_urban_2_1_2[$key] ?? null;
                $table2_1_2->male_total = ((int)$request->male_rural_2_1_2[$key] ?? 0) + ((int)$request->male_urban_2_1_2[$key] ?? 0);
                $table2_1_2->female_rural = $request->female_rural_2_1_2[$key] ?? null;
                $table2_1_2->female_urban = $request->female_urban_2_1_2[$key] ?? null;
                $table2_1_2->female_total = ((int)$request->female_rural_2_1_2[$key] ?? 0) + ((int)$request->female_urban_2_1_2[$key] ?? 0);
                $table2_1_2->others_rural = $request->others_rural_2_1_2[$key] ?? null;
                $table2_1_2->others_urban = $request->others_urban_2_1_2[$key] ?? null;
                $table2_1_2->others_total = ((int)$request->others_rural_2_1_2[$key] ?? 0) + ((int)$request->others_urban_2_1_2[$key] ?? 0);
                $table2_1_2->total_rural = ((int)$request->male_rural_2_1_2[$key] ?? 0) + ((int)$request->female_rural_2_1_2[$key] ?? 0)+ ((int)$request->others_rural_2_1_2[$key] ?? 0);
                $table2_1_2->total_urban = ((int)$request->male_urban_2_1_2[$key] ?? 0) + ((int)$request->female_urban_2_1_2[$key] ?? 0) + ((int)$request->others_urban_2_1_2[$key] ?? 0);
                $table2_1_2->total_total = $table2_1_2->total_rural + $table2_1_2->total_urban ;
                $table2_1_2->save();
            }

            //Tab2.2.1
            $detailsTableId_2_2_1 = $request->mef_nbfis_details_table_2_2_1_id??null;
            $table2_2_1 = MefNbfisDetailsTable2_2_1::findOrNew($detailsTableId_2_2_1);
            $table2_2_1->master_id = $mefNbfisMaster->id;
            $table2_2_1->large_loan_rural = $request->large_loan_rural_2_2_1  ?? null;
            $table2_2_1->large_loan_urban = $request->large_loan_urban_2_2_1  ?? null;
            $table2_2_1->cottage_rural = $request->cottage_rural_2_2_1  ?? null;
            $table2_2_1->cottage_urban = $request->cottage_urban_2_2_1  ?? null;
            $table2_2_1->micro_rural = $request->micro_rural_2_2_1  ?? null;
            $table2_2_1->micro_urban = $request->micro_urban_2_2_1  ?? null;
            $table2_2_1->small_rural = $request->small_rural_2_2_1  ?? null;
            $table2_2_1->small_urban = $request->small_urban_2_2_1  ?? null;
            $table2_2_1->medium_rural = $request->medium_rural_2_2_1  ?? null;
            $table2_2_1->medium_urban = $request->medium_urban_2_2_1  ?? null;
            $table2_2_1->other_rural = $request->other_rural_2_2_1  ?? null;
            $table2_2_1->other_urban = $request->other_urban_2_2_1  ?? null;
            $table2_2_1->total_rural = (intval($request->large_loan_rural_2_2_1) ?? 0) + (intval($request->cottage_rural_2_2_1) ?? 0) 
            +(intval($request->micro_rural_2_2_1) ?? 0) +(intval($request->small_rural_2_2_1) ?? 0) 
            +(intval($request->medium_rural_2_2_1) ?? 0) + (intval($request->other_rural_2_2_1) ?? 0);
            $table2_2_1->total_urban =((int)$request->large_loan_urban_2_2_1 ?? 0) + ((int)$request->cottage_urban_2_2_1 ?? 0) 
            +((int)$request->micro_urban_2_2_1 ?? 0) +((int)$request->small_urban_2_2_1 ?? 0) 
            +((int)$request->medium_urban_2_2_1 ?? 0) + ((int)$request->other_urban_2_2_1 ?? 0);
            $table2_2_1->total_total = intval($table2_2_1->total_rural) + intval($table2_2_1->total_urban) ;
            $table2_2_1->save();


            //Tab2.2.2
            foreach ($request->mef_nbfis_label_id_2_2_2 as $key => $item) {
                $detailsTableId_2_2_2 = $request->mef_nbfis_details_table_2_2_2_id[$key] ?? null;
                $table2_2_2 = MefNbfisDetailsTable2_2_2::findOrNew($detailsTableId_2_2_2);
                $table2_2_2->master_id = $mefNbfisMaster->id;
                $table2_2_2->mef_nbfis_label_id = $item;
                $table2_2_2->male_rural = $request->male_rural_2_2_2[$key] ?? null;
                $table2_2_2->male_urban = $request->male_urban_2_2_2[$key] ?? null;
                $table2_2_2->male_total = ((int)$request->male_rural_2_2_2[$key] ?? 0) + ((int)$request->male_urban_2_2_2[$key] ?? 0);
                $table2_2_2->female_rural = $request->female_rural_2_2_2[$key] ?? null;
                $table2_2_2->female_urban = $request->female_urban_2_2_2[$key] ?? null;
                $table2_2_2->female_total = ((int)$request->female_rural_2_2_2[$key] ?? 0) + ((int)$request->female_urban_2_2_2[$key] ?? 0);
                $table2_2_2->others_rural = $request->others_rural_2_2_2[$key] ?? null;
                $table2_2_2->others_urban = $request->others_urban_2_2_2[$key] ?? null;
                $table2_2_2->others_total = ((int)$request->others_rural_2_2_2[$key] ?? 0) + ((int)$request->others_urban_2_2_2[$key] ?? 0);
                $table2_2_2->total_rural = ((int)$request->male_rural_2_2_2[$key] ?? 0) + ((int)$request->female_rural_2_2_2[$key] ?? 0)+ ((int)$request->others_rural_2_2_2[$key] ?? 0);
                $table2_2_2->total_urban = ((int)$request->male_urban_2_2_2[$key] ?? 0) + ((int)$request->female_urban_2_2_2[$key] ?? 0) + ((int)$request->others_urban_2_2_2[$key] ?? 0);
                $table2_2_2->total_total = intval($table2_2_2->total_rural) + intval($table2_2_2->total_urban) ;
                $table2_2_2->save();
            }


            //3. Loan Classification
            foreach ($request->mef_nbfis_label_id_3 as $key => $item) {
                $detailsTableId_3 = $request->mef_nbfis_details_table_3_id[$key] ?? null;
                $table3 = MefNbfisDetailsTable3::findOrNew($detailsTableId_3);
                $table3->master_id = $mefNbfisMaster->id;
                $table3->mef_nbfis_label_id = $item;
                $table3->u_standard_male = $request->u_standard_male_3[$key] ?? null;
                $table3->u_standard_female = $request->u_standard_female_3[$key] ?? null;
                $table3->u_standard_others = $request->u_standard_others_3[$key] ?? null;
                $table3->u_standard_joint = $request->u_standard_joint_3[$key] ?? null;
                $table3->u_standard_enterprise = $request->u_standard_enterprise_3[$key] ?? null;
                $table3->u_standard_total = ((int)$request->u_standard_male_3[$key] ?? 0) +((int)$request->u_standard_female_3[$key] ?? 0) +((int)$request->u_standard_others_3[$key] ?? 0) +((int)$request->u_standard_joint_3[$key] ?? 0) +((int)$request->u_standard_enterprise_3[$key] ?? 0) ;
                $table3->u_sma_male = $request->u_sma_male_3[$key] ?? null;
                $table3->u_sma_female = $request->u_sma_female_3[$key] ?? null;
                $table3->u_sma_others = $request->u_sma_others_3[$key] ?? null;
                $table3->u_sma_joint = $request->u_sma_joint_3[$key] ?? null;
                $table3->u_sma_enterprise = $request->u_sma_enterprise_3[$key] ?? null;
                $table3->u_sma_total = ((int)$request->u_sma_male_3[$key] ?? 0) +((int)$request->u_sma_female_3[$key] ?? 0) +((int)$request->u_sma_others_3[$key] ?? 0)  +((int)$request->u_sma_joint_3[$key] ?? 0) +((int)$request->u_sma_enterprise_3[$key] ?? 0) ;
                $table3->c_ss_male = $request->c_ss_male_3[$key] ?? null;
                $table3->c_ss_female = $request->c_ss_female_3[$key] ?? null;
                $table3->c_ss_others = $request->c_ss_others_3[$key] ?? null;
                $table3->c_ss_joint = $request->c_ss_joint_3[$key] ?? null;
                $table3->c_ss_enterprise = $request->c_ss_enterprise_3[$key] ?? null;
                $table3->c_ss_total = ((int)$request->c_ss_male_3[$key] ?? 0) +((int)$request->c_ss_female_3[$key] ?? 0) +((int)$request->c_ss_others_3[$key] ?? 0) +((int)$request->c_ss_joint_3[$key] ?? 0) +((int)$request->c_ss_enterprise_3[$key] ?? 0) ;
                $table3->c_df_male = $request->c_df_male_3[$key] ?? null;
                $table3->c_df_female = $request->c_df_female_3[$key] ?? null;
                $table3->c_df_others = $request->c_df_others_3[$key] ?? null;
                $table3->c_df_joint = $request->c_df_joint_3[$key] ?? null;
                $table3->c_df_enterprise = $request->c_df_enterprise_3[$key] ?? null;
                $table3->c_df_total = ((int)$request->c_df_male_3[$key] ?? 0) +((int)$request->c_df_female_3[$key] ?? 0) +((int)$request->c_df_others_3[$key] ?? 0) +((int)$request->c_df_joint_3[$key] ?? 0) +((int)$request->c_df_enterprise_3[$key] ?? 0) ;
                $table3->c_bl_male = $request->c_bl_male_3[$key] ?? null;
                $table3->c_bl_female = $request->c_bl_female_3[$key] ?? null;
                $table3->c_bl_others = $request->c_bl_others_3[$key] ?? null;
                $table3->c_bl_joint = $request->c_bl_joint_3[$key] ?? null;
                $table3->c_bl_enterprise = $request->c_bl_enterprise_3[$key] ?? null;
                $table3->c_bl_total = ((int)$request->c_bl_male_3[$key] ?? 0) +((int)$request->c_bl_female_3[$key] ?? 0) +((int)$request->c_bl_others_3[$key] ?? 0) +((int)$request->c_bl_joint_3[$key] ?? 0) +((int)$request->c_bl_enterprise_3[$key] ?? 0) ;
                $table3->total_male =((int)$request->u_standard_male_3[$key] ?? 0) + ((int)$request->u_sma_male_3[$key] ?? 0) + ((int)$request->c_ss_male_3[$key] ?? 0) 
                    + ((int)$request->c_df_male_3[$key] ?? 0) + ((int)$request->c_bl_male_3[$key] ?? 0) ;
                $table3->total_female =((int)$request->u_standard_female_3[$key] ?? 0) + ((int)$request->u_sma_female_3[$key] ?? 0) 
                    + ((int)$request->c_ss_female_3[$key] ?? 0) + ((int)$request->c_df_female_3[$key] ?? 0) + ((int)$request->c_bl_female_3[$key] ?? 0);
                $table3->total_others =((int)$request->u_standard_others_3[$key] ?? 0) + ((int)$request->u_sma_others_3[$key] ?? 0) 
                    + ((int)$request->c_ss_others_3[$key] ?? 0) + ((int)$request->c_df_others_3[$key] ?? 0) + ((int)$request->c_bl_others_3[$key] ?? 0);
                $table3->total_joint =((int)$request->u_standard_joint_3[$key] ?? 0) + ((int)$request->u_sma_joint_3[$key] ?? 0) 
                    + ((int)$request->c_ss_joint_3[$key] ?? 0) + ((int)$request->c_df_joint_3[$key] ?? 0) + ((int)$request->c_bl_joint_3[$key] ?? 0);
                $table3->total_enterprise =((int)$request->u_standard_enterprise_3[$key] ?? 0) + ((int)$request->u_sma_enterprise_3[$key] ?? 0) 
                    + ((int)$request->c_ss_enterprise_3[$key] ?? 0) + ((int)$request->c_df_enterprise_3[$key] ?? 0) + ((int)$request->c_bl_enterprise_3[$key] ?? 0);
                $table3->total_total = $table3->total_male + $table3->total_female +  $table3->total_others +  $table3->total_joint + $table3->total_enterprise;
                $table3->save();
            }

            // MefNbfisDetailsTable4
            $detailsTableId_4 = $request->mef_nbfis_details_table_4_id??null;
            $table4 = MefNbfisDetailsTable4::findOrNew($detailsTableId_4);
            $table4->master_id = $mefNbfisMaster->id;
            $table4->nauib_rural = $request->nauib_rural_4  ?? null;
            $table4->nauib_urban = $request->nauib_urban_4  ?? null;
            $table4->nauib_total = ((int)$request->nauib_rural_4 ?? 0) + ((int)$request->nauib_urban_4 ?? 0) ;
            $table4->ccu_rural = $request->ccu_rural_4  ?? null;
            $table4->ccu_urban = $request->ccu_urban_4  ?? null;
            $table4->ccu_total = ((int)$request->ccu_rural_4 ?? 0) + ((int)$request->ccu_urban_4 ?? 0) ;
            $table4->save();

            // 5. Access Point Related Information
            $detailsTableId_5 = $request->mef_nbfis_details_table_5_id??null;
            $table5 = MefNbfisDetailsTable5::findOrNew($detailsTableId_5);
            $table5->master_id = $mefNbfisMaster->id;
            $table5->nb_rural = $request->nb_rural_5  ?? null;
            $table5->nb_urban = $request->nb_urban_5  ?? null;
            $table5->nb_total = ((int)$request->nb_rural_5 ?? 0) + ((int)$request->nb_urban_5 ?? 0) ;
            $table5->nob_rural = $request->nob_rural_5  ?? null;
            $table5->nob_urban = $request->nob_urban_5  ?? null;
            $table5->nob_total = ((int)$request->nob_rural_5 ?? 0) + ((int)$request->nob_urban_5 ?? 0) ;
            $table5->save();

            // MefNbfisDetailsTable6
            $detailsTableId_6 = $request->mef_nbfis_details_table_6_id??null; 
            $table6 = MefNbfisDetailsTable6::findOrNew($detailsTableId_6); 
            $table6->master_id = $mefNbfisMaster->id;
            $table6->nflpo_dhaka = $request->nflpo_dhaka_6  ?? null;
            $table6->nflpo_others_region = $request->nflpo_others_region_6  ?? null;
            $table6->nflpo_total = ((int)$request->nflpo_dhaka_6 ?? 0) + ((int)$request->nflpo_others_region_6 ?? 0);
            $table6->np_male = $request->np_male_6  ?? null;
            $table6->np_female = $request->np_female_6  ?? null;
            $table6->np_others = $request->np_others_6  ?? null;
            $table6->np_total = ((int)$request->np_male_6 ?? 0) + ((int)$request->np_female_6 ?? 0) + ((int)$request->np_others_6 ?? 0);
            $table6->save();

            $detailsTableId8 = $request->mef_nbfis_details_table_8_id??null; 
            $table8 = MefNbfisDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $mefNbfisMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();
            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in NbfisService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefNbfisService-61]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data['mefNbfisDetailsTable1_1'] = MefNbfisDetailsTable1_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable1_2'] = MefNbfisDetailsTable1_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable1_3'] = MefNbfisDetailsTable1_3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable1_4'] = MefNbfisDetailsTable1_4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable1_5'] = MefNbfisDetailsTable1_5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable2_1_1'] = MefNbfisDetailsTable2_1_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefNbfisDetailsTable2_1_2'] = MefNbfisDetailsTable2_1_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable2_2_1'] = MefNbfisDetailsTable2_2_1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefNbfisDetailsTable2_2_2'] = MefNbfisDetailsTable2_2_2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable3'] = MefNbfisDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefNbfisDetailsTable6'] = MefNbfisDetailsTable6::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefNbfisDetailsTable8'] = MefNbfisDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefNbfisDetailsTable4'] = MefNbfisDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefNbfisDetailsTable5'] = MefNbfisDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();

            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in NbfisService@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [MefNbfisService-61]");
            return redirect()->back();
        }
    }

}