<?php
namespace App\Modules\MonitoringFramework\Services;


use App\Libraries\Encryption;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable8;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable1;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable2;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable3;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable4;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable5;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsDetailsTable6;
use App\Modules\MonitoringFramework\Models\Mfs\MefMfsMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MfsService
{

    public function store($request)
    {

        try {

            if (!Auth::user()->organization_id) {
                Session::flash('error', "Invalid organization, Please login with valid organization!");
                return redirect()->back();
            }

            $isExist = MefMfsMaster::query()->where('organization_id', Auth::user()->organization_id)->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            if ($isExist && !$request->master_id) {
                Session::flash('error', "Data already exist for this year and quarter!");
                return redirect()->back();
            }

            DB::beginTransaction();
            if ($request->master_id) {
                $master_id = Encryption::decodeId($request->master_id);

                $mefMfsMaster = MefMfsMaster::findOrFail($master_id);
            } else {
                $mefMfsMaster = new MefMfsMaster();
            }
            $mefMfsMaster->year = $request->year ?? null;
            $mefMfsMaster->mef_quarter_id = $request->quarter ?? null;
            $mefMfsMaster->organization_id = Auth::user()->organization_id ?? null;
            $mefMfsMaster->mef_process_status_id = '-1'; // Draft
            if ($request->actionBtn == 'submit') {
                $mefMfsMaster->mef_process_status_id = 1; // Submitted
            }
            $mefMfsMaster->save();

            // 1. Account Related Information
            if (isset($request->mef_mfs_table1_label_id))
            {
                foreach ($request->mef_mfs_table1_label_id as $key => $item) {
                    $table1 = MefMfsDetailsTable1::firstOrNew(['mef_mfs_label_id' => $item, 'master_id' => $mefMfsMaster->id]);
                    $table1->master_id = $mefMfsMaster->id;
                    $table1->mef_mfs_label_id = $request->mef_mfs_table1_label_id[$key] ?? null;

                    $table1->male_rural = $request->male_rural[$key] ?? 0;
                    $table1->male_urban = $request->male_urban[$key] ?? 0;
                    $table1->male_total = intval($request->male_rural[$key] ?? 0) + intval($request->male_urban[$key] ?? 0);

                    $table1->female_rural = $request->female_rural[$key] ?? 0;
                    $table1->female_urban = $request->female_urban[$key] ?? 0;
                    $table1->female_total = intval($request->female_rural[$key] ?? 0) + intval($request->female_urban[$key] ?? 0) ;


                    $table1->others_rural = $request->others_rural[$key] ?? 0;
                    $table1->others_urban = $request->others_urban[$key] ?? 0;
                    $table1->others_total = intval($request->others_rural[$key] ?? 0) + intval($request->others_urban[$key] ?? 0);

                    $table1->total_rural = intval($request->male_rural[$key] ?? 0) + intval($request->female_rural[$key] ?? 0) + intval($request->others_rural[$key] ?? 0);
                    $table1->total_urban = intval($request->male_urban[$key] ?? 0) + intval($request->female_urban[$key] ?? 0) + intval($request->others_urban[$key] ?? 0);

                    $table1->save();
                }
            }

            // 2. Transaction Information (Number of Transaction)
            if (isset($request->mef_mfs_table2_label_id))
            {
                foreach ($request->mef_mfs_table2_label_id as $key => $item) {
                    $table2 = MefMfsDetailsTable2::firstOrNew(['mef_mfs_label_id' => $item, 'master_id' => $mefMfsMaster->id]);
                    $table2->master_id = $mefMfsMaster->id;
                    $table2->mef_mfs_label_id =$request->mef_mfs_table2_label_id[$key] ?? null;

                    $table2->male_rural = $request->male_rural2[$key] ?? 0;
                    $table2->male_urban = $request->male_urban2[$key] ?? 0;
                    $table2->male_total = intval($request->male_rural2[$key] ?? 0) + intval($request->male_urban2[$key] ?? 0);


                    $table2->female_rural = $request->female_rural2[$key] ?? 0;
                    $table2->female_urban = $request->female_urban2[$key] ?? 0;
                    $table2->female_total = intval($request->female_rural2[$key] ?? 0)+intval($request->female_urban2[$key] ?? 0);


                    $table2->others_rural = $request->others_rural2[$key] ?? 0;
                    $table2->others_urban = $request->others_urban2[$key] ?? 0;
                    $table2->others_total = intval($request->others_rural2[$key] ?? 0) + intval($request->others_urban2[$key] ?? 0);

                    $table2->total_rural = intval($request->male_rural2[$key] ?? 0) + intval($request->female_rural2[$key] ?? 0) + intval($request->others_rural2[$key] ?? 0);
                    $table2->total_urban =intval($request->male_urban2[$key] ?? 0) + intval($request->female_urban2[$key] ?? 0) + intval($request->others_urban2[$key] ?? 0);

                    $table2->save();
                }
            }

            // 3. Transaction Information (Volume of Transaction)
            if (isset($request->mef_mfs_table3_label_id))
            {
                foreach ($request->mef_mfs_table3_label_id as $key => $item) {
                    $table3 = MefMfsDetailsTable3::firstOrNew(['mef_mfs_label_id' => $item, 'master_id' => $mefMfsMaster->id]);
                    $table3->master_id = $mefMfsMaster->id;
                    $table3->mef_mfs_label_id =$request->mef_mfs_table3_label_id[$key] ?? null;
                    $table3->male_rural = $request->male_rural3[$key] ?? 0;
                    $table3->male_urban = $request->male_urban3[$key] ?? 0;
                    $table3->male_total = intval($request->male_rural3[$key] ?? 0) + intval($request->male_urban3[$key] ?? 0);

                    $table3->female_rural = $request->female_rural3[$key] ?? 0;
                    $table3->female_urban = $request->female_urban3[$key] ?? 0;
                    $table3->female_total = intval($request->female_rural3[$key] ?? 0) + intval($request->female_urban3[$key] ?? 0);

                    $table3->others_rural = $request->others_rural3[$key] ?? 0;
                    $table3->others_urban = $request->others_urban3[$key] ?? 0;
                    $table3->others_total = intval($request->others_rural3[$key] ?? 0) + intval($request->others_urban3[$key] ?? 0);

                    $table3->total_rural = intval($request->male_rural3[$key] ?? 0) + intval($request->female_rural3[$key] ?? 0) + intval($request->others_rural3[$key] ?? 0);
                    $table3->total_urban = intval($request->male_urban3[$key] ?? 0) + intval($request->female_urban3[$key] ?? 0) + intval($request->others_urban3[$key] ?? 0);
                    $table3->save();
                }

            }

            // 4. Foreign Remittance
            $table4 = MefMfsDetailsTable4::firstOrNew(['mef_mfs_label_id' => $request->mef_mfs_table4_label_id, 'master_id' => $mefMfsMaster->id]);
            $table4->master_id = $mefMfsMaster->id;
            $table4->mef_mfs_label_id = $request->mef_mfs_table4_label_id ?? null;

            $table4->nt_male_rural = $request->nt_male_rural ?? 0;
            $table4->nt_male_urban = $request->nt_male_urban ?? 0;

            $table4->nt_female_rural = $request->nt_female_rural ?? 0;
            $table4->nt_female_urban = $request->nt_female_urban ?? 0;

            $table4->nt_others_rural = $request->nt_others_rural ?? 0;
            $table4->nt_others_urban = $request->nt_others_urban ?? 0;

            $table4->nt_total_rural = intval($request->nt_male_rural ?? 0) + intval($request->nt_female_rural ?? 0) + intval($request->nt_others_rural ?? 0);
            $table4->nt_total_urban = intval($request->nt_male_urban ?? 0) + intval($request->nt_female_urban ?? 0) + intval($request->nt_others_urban ?? 0);

            $table4->vt_male_rural = $request->vt_male_rural ?? 0;
            $table4->vt_male_urban = $request->vt_male_urban ?? 0;

            $table4->vt_female_rural = $request->vt_female_rural ?? 0;
            $table4->vt_female_urban = $request->vt_female_urban ?? 0;

            $table4->vt_others_rural = $request->vt_others_rural ?? 0;
            $table4->vt_others_urban = $request->vt_others_urban ?? 0;

            $table4->vt_total_rural = intval($request->vt_male_rural ?? 0) + intval($request->vt_female_rural ?? 0) + intval($request->vt_others_rural ?? 0);
            $table4->vt_total_urban = intval($request->vt_male_urban ?? 0) + intval($request->vt_female_urban ?? 0) + intval($request->vt_others_urban ?? 0);

            $table4->save();

            // 5. Agent Information
            $table5 = MefMfsDetailsTable5::firstOrNew(['master_id' => $mefMfsMaster->id]);
            $table5->master_id = $mefMfsMaster->id;
            $table5->mef_mfs_label_id =$request->mef_mfs_table5_label_id ?? null;
            $table5->male_rural = $request->male_rural5 ?? 0;
            $table5->male_urban = $request->male_urban5 ?? 0;
            $table5->female_rural = $request->female_rural5 ?? 0;
            $table5->female_urban = $request->female_urban5 ?? 0;
            $table5->others_rural = $request->others_rural5 ?? 0;
            $table5->others_urban = $request->others_urban5 ?? 0;
            $table5->total_rural = intval($request->male_rural5 ?? 0) + intval($request->female_rural5?? 0) + intval($request->others_rural5 ?? 0) ;
            $table5->total_urban = intval($request->male_urban5 ?? 0) + intval($request->female_urban5 ?? 0) + intval($request->others_urban5 ?? 0);
            $table5->total_total = intval($table5->total_rural ?? 0) + intval($table5->total_urban ?? 0);
            $table5->save();

            // 6. Financial Literacy Programmes (During the quarter)
            $table6 = MefMfsDetailsTable6::firstOrNew(['master_id' => $mefMfsMaster->id]);
            $table6->master_id = $mefMfsMaster->id;
            $table6->mef_mfs_label_id =$request->mef_mfs_table6_label_id ?? null;
            $table6->nflpo_dhaka = $request->nflpo_dhaka ?? 0;
            $table6->nflpo_other_regions = $request->nflpo_other_regions ?? 0;
            $table6->nflpo_total =  intval($request->nflpo_dhaka ?? 0) + intval($request->nflpo_other_regions ?? 0);

            $table6->np_male = $request->np_male ?? 0;
            $table6->np_female = $request->np_female ?? 0;
            $table6->np_others = $request->np_others ?? 0;
            $table6->np_total = intval($request->np_male ?? 0) + intval($request->np_female ?? 0) + intval($request->np_others ?? 0);
            $table6->save();

            $detailsTableId8 = $request->mef_mfs_details_table_8_id??null; 
            $table8 = MefMfsDetailsTable8::findOrNew($detailsTableId8); 
            $table8->master_id = $mefMfsMaster->id;
            $table8->complaints_received = $request->complaints_received  ?? null;
            $table8->complaints_resolved = $request->complaints_resolved  ?? null;
            $table8->received_resolved = ($request->complaints_received ? (float)$request->complaints_received : 0) / ((int)$request->complaints_resolved ? (float)$request->complaints_resolved : 1);
            $table8->save();


            DB::commit();

            Session::flash('success', 'Data save successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error occurred in MefMfsController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [MefMfsMaster-102]");
            return Redirect::back()->withInput();
        }
    }


    public function summaryReport($request)
    {
        try {
            $data = [];
            $data['mefMfsDetailsTable1'] = MefMfsDetailsTable1::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfsDetailsTable2'] = MefMfsDetailsTable2::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfsDetailsTable3'] = MefMfsDetailsTable3::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->get();
            $data['mefMfsDetailsTable4'] = MefMfsDetailsTable4::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfsDetailsTable5'] = MefMfsDetailsTable5::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfsDetailsTable6'] = MefMfsDetailsTable6::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            $data['mefMfsDetailsTable8'] = MefMfsDetailsTable8::sumColumns()->where('year', $request->year)->where('mef_quarter_id', $request->quarter)->first();
            return $data;
        } catch (\Exception $e) {
            Log::error("Error occurred in MefMfsController@summaryReport ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data edit [MefMfsMaster-104]");
            return redirect()->back();
        }
    }

}
