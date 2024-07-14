<?php
namespace App\Modules\MonitoringFramework\Services;


use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable1;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable2;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable3;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable4;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable5;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesDetailsTable8;
use App\Modules\MonitoringFramework\Models\Cooperatives\MefCooperativesMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CooperativesService
{

    public function store($request)
    {

        try {

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefCooperativesMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);
                $mefCooperativesMaster = MefCooperativesMaster::findOrFail($master_id);
            } else {
                $mefCooperativesMaster = new MefCooperativesMaster();
            }
            $mefCooperativesMaster->year = $request->year ?? null;
            $mefCooperativesMaster->mef_quarter_id = $request->quarter ?? null;
            $mefCooperativesMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefCooperativesMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefCooperativesMaster->mef_process_status_id = 1; // Submitted
            }
            $mefCooperativesMaster->save();

            // 1. Number of Account with Cooperative Societies
            if (isset($request->district_id)) {
                foreach ($request->district_id as $key => $item) {
                    // ob@22 check model object working when edit action, use table id
                    // like $detailsTableId = $request->mef_mfis_details_table_1_id[$key] ?? null;
                    // $table1 = MefMfisDetailsTable1::findOrNew($detailsTableId);
                    $table1 = MefCooperativesDetailsTable1::firstOrNew(['district_id' => $item, 'master_id' => $mefCooperativesMaster->id]);
                    $table1->master_id = $mefCooperativesMaster->id;
                    $table1->district_id = $item;
                    $table1->division_id = $request->division_id[$key] ?? null;

                    $table1->tnm_male = $request->tnm_male[$key] ?? null;
                    $table1->tnm_female = $request->tnm_female[$key] ?? null;
                    $table1->tnm_others = $request->tnm_others[$key] ?? null;
                    $table1->tnm_total = intval($request->tnm_male[$key] ?? 0) + intval($request->tnm_female[$key] ?? 0) + intval($request->tnm_others[$key] ?? 0);
                    $table1->tna_male = $request->tna_male[$key] ?? null;
                    $table1->tna_female = $request->tna_female[$key] ?? null;
                    $table1->tna_others = $request->tna_others[$key] ?? null;
                    $table1->tna_total = intval($request->tna_male[$key] ?? 0) + intval($request->tna_female[$key] ?? 0) + intval($request->tna_others[$key] ?? 0);


                    $table1->nsa_male = $request->nsa_male[$key] ?? null;
                    $table1->nsa_female = $request->nsa_female[$key] ?? null;
                    $table1->nsa_others = $request->nsa_others[$key] ?? null;
                    $table1->nsa_total = intval($request->nsa_male[$key] ?? 0) + intval($request->nsa_female[$key] ?? 0) + intval($request->nsa_others[$key] ?? 0);


                    $table1->nla_male = $request->nla_male[$key] ?? null;
                    $table1->nla_female = $request->nla_female[$key] ?? null;
                    $table1->nla_others = $request->nla_others[$key] ?? null;
                    $table1->nla_total = intval($request->nla_male[$key] ?? 0) + intval($request->nla_female[$key] ?? 0) + intval($request->nla_others[$key] ?? 0);
                    $table1->save();

                }
            }

            // 2. Balance/Outstanding amount with Cooperative Societies
            if (isset($request->district_id_1)) {
                foreach ($request->district_id_1 as $key => $item) {
                    // ob@23 check model object working when edit action
                    $table2 = MefCooperativesDetailsTable2::firstOrNew(['district_id' => $item, 'master_id' => $mefCooperativesMaster->id]);
                    $table2->master_id = $mefCooperativesMaster->id;
                    $table2->district_id = $item;
                    $table2->division_id = $request->division_id[$key] ?? null;

                    $table2->dbtm_male = $request->dbtm_male[$key] ?? null;
                    $table2->dbtm_female = $request->dbtm_female[$key] ?? null;
                    $table2->dbtm_others = $request->dbtm_others[$key] ?? null;
                    $table2->dbtm_total = intval($request->dbtm_male[$key] ?? 0) + intval($request->dbtm_female[$key] ?? 0) + intval($request->dbtm_others[$key] ?? 0);

                    $table2->bta_male = $request->bta_male[$key] ?? null;
                    $table2->bta_female = $request->bta_female[$key] ?? null;
                    $table2->bta_others = $request->bta_others[$key] ?? null;
                    $table2->bta_total = intval($request->bta_male[$key] ?? 0) + intval($request->bta_female[$key] ?? 0) + intval($request->bta_others[$key] ?? 0);


                    $table2->dbsa_male = $request->dbsa_male[$key] ?? null;
                    $table2->dbsa_female = $request->dbsa_female[$key] ?? null;
                    $table2->dbsa_others = $request->dbsa_others[$key] ?? null;
                    $table2->dbsa_total = intval($request->dbsa_male[$key] ?? 0) + intval($request->dbsa_female[$key] ?? 0) + intval($request->dbsa_others[$key] ?? 0);


                    $table2->obla_male = $request->obla_male[$key] ?? null;
                    $table2->obla_female = $request->obla_female[$key] ?? null;
                    $table2->obla_others = $request->obla_others[$key] ?? null;
                    $table2->obla_total = intval($request->obla_male[$key] ?? 0) + intval($request->obla_female[$key] ?? 0) + intval($request->obla_others[$key] ?? 0);
                    $table2->save();

                }
            }

            // 3. Automation in Cooperatives
            // ob@24 check model object working when edit action
            $table3 = MefCooperativesDetailsTable3::firstOrNew(['master_id' => $mefCooperativesMaster->id]);
            $table3->maui_male = $request->maui_male ?? 0;
            $table3->maui_female = $request->maui_female ?? 0;
            $table3->maui_others = $request->maui_others ?? 0;
            $table3->maui_total = intval($request->maui_others ?? 0) + intval($request->maui_female ?? 0) + intval($request->maui_others ?? 0);

            $table3->brlt_mfs_male = $request->brlt_mfs_male ?? 0;
            $table3->brlt_mfs_female = $request->brlt_mfs_female ?? 0;
            $table3->brlt_mfs_others = $request->brlt_mfs_others ?? 0;
            $table3->brlt_total = intval($request->brlt_mfs_others ?? 0) + intval($request->brlt_mfs_female ?? 0) + intval($request->brlt_mfs_others ?? 0);

            $table3->nbpit_mfs_male = $request->nbpit_mfs_male ?? 0;
            $table3->nbpit_mfs_female = $request->nbpit_mfs_female ?? 0;
            $table3->nbpit_mfs_others = $request->nbpit_mfs_others ?? 0;
            $table3->nbpit_total = intval($request->nbpit_mfs_others ?? 0) + intval($request->nbpit_mfs_female ?? 0) + intval($request->nbpit_mfs_others ?? 0);
            $table3->save();


            // 4. Business Centres
            // ob@25 check model object working when edit action
            $table4 = MefCooperativesDetailsTable4::firstOrNew(['master_id' => $mefCooperativesMaster->id]);

            $table4->noc = $request->noc ?? 0;
            $table4->nob = $request->nob ?? 0;
            $table4->noob = $request->noob ?? 0;

            $table4->save();


            // 5. Financial Literacy Programmes (During the quarter)
            // ob@26 check model object working when edit action
            $table5 = MefCooperativesDetailsTable5::firstOrNew(['master_id' => $mefCooperativesMaster->id]);
            $table5->nflpo_dhaka = $request->nflpo_dhaka ?? 0;
            $table5->nflpo_other_region = $request->nflpo_other_region ?? 0;
            $table5->nflpo_total = intval($request->nflpo_dhaka ?? 0) + intval($request->nflpo_other_region ?? 0);

            $table5->nop_male = $request->nop_male ?? 0;
            $table5->nop_female = $request->nop_female ?? 0;
            $table5->nop_others = $request->nop_others ?? 0;
            $table5->nop_total = intval($request->nop_male ?? 0) + intval($request->nop_female ?? 0) + intval($request->nop_others ?? 0);
            $table5->save();

            $detailsTableId8 = $request->mef_cooperatives_details_table_8_id??null; 
            $table8 = MefCooperativesDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $mefCooperativesMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();

            DB::commit();

            Session::flash('success', 'Data save successfully!');


        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in CooperativesService@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [CooperativesService-102]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data = [];
            $data['mefCooperativesDetailsTable1'] = MefCooperativesDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefCooperativesDetailsTable2'] = MefCooperativesDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefCooperativesDetailsTable3'] = MefCooperativesDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefCooperativesDetailsTable4'] = MefCooperativesDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefCooperativesDetailsTable5'] = MefCooperativesDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefCooperativesDetailsTable8'] = MefCooperativesDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();

            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in CooperativesService@summary_report ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong [CooperativesService-105]");
            return redirect()->back();
        }
    }

}
