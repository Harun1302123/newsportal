
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold"> 1. Account Related Information </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="5">Number of Beneficiary of NSC</th>
                                    <th class="text-center" colspan="4">Number of Accounts with BPO</th>
                                    <th class="text-center" colspan="4">Number of Postal Life Insurance Policy Holders</th>
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Joint</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                @php
                                    // dd($master_data->mefMfisDetailsTable1->sortBy('division_id')->all())
                                @endphp
                                @if ($mefNsdDetailsTable1->count())
                                    @php
                                    $total_nb_nsc_male = 0;
                                    $total_nb_nsc_female = 0;
                                    $total_nb_nsc_others = 0;
                                    $total_nb_nsc_total = 0;
                                    $total_nb_nsc_joint = 0;
                                    $total_na_bpo_male = 0;
                                    $total_na_bpo_female = 0;
                                    $total_na_bpo_others = 0;
                                    $total_na_bpo_total = 0;
                                    $total_np_liph_male = 0;
                                    $total_np_liph_female = 0;
                                    $total_np_liph_others = 0;
                                    $total_np_liph_total = 0;
                                    @endphp
                                    @foreach ($mefNsdDetailsTable1->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_nb_nsc_male += $item->nb_nsc_male??0;
                                            $total_nb_nsc_female += $item->nb_nsc_female??0;
                                            $total_nb_nsc_others += $item->nb_nsc_others??0;
                                            $total_nb_nsc_joint += $item->nb_nsc_joint??0;
                                            $total_nb_nsc_total += $item->nb_nsc_total??0;

                                            $total_na_bpo_male += $item->na_bpo_male??0;
                                            $total_na_bpo_female += $item->na_bpo_female??0;
                                            $total_na_bpo_others += $item->na_bpo_others??0;
                                            $total_na_bpo_total += $item->na_bpo_total??0;

                                            $total_np_liph_male += $item->np_liph_male??0;
                                            $total_np_liph_female += $item->np_liph_female??0;
                                            $total_np_liph_others += $item->np_liph_others??0;
                                            $total_np_liph_total += $item->np_liph_total??0;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm ?? null }}</td>
                                            <td>{{ $item->district->area_nm ?? null }}</td>
                                            <td>{{ $item->nb_nsc_male ?? null }}</td>
                                            <td>{{ $item->nb_nsc_female ?? null }}</td>
                                            <td>{{ $item->nb_nsc_others ?? null }}</td>
                                            <td>{{ $item->nb_nsc_joint ?? null }}</td>
                                            <td class="text-bold">{{ $item->nb_nsc_total ?? null }}</td>
                                            <td>{{ $item->na_bpo_male ?? null }}</td>
                                            <td>{{ $item->na_bpo_female ?? null }}</td>
                                            <td>{{ $item->na_bpo_others ?? null }}</td>
                                            <td class="text-bold">{{ $item->na_bpo_total ?? null }}</td>
                                            <td>{{ $item->np_liph_male ?? null }}</td>
                                            <td>{{ $item->np_liph_female ?? null }}</td>
                                            <td>{{ $item->np_liph_others ?? null }}</td>
                                            <td class="text-bold">{{ $item->np_liph_total ?? null }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-bold">
                                        <td class="text-center" colspan="2">Total</td>
                                        <td>{{ $total_nb_nsc_male ?? 0 }}</td>
                                        <td>{{ $total_nb_nsc_female ?? 0 }}</td>
                                        <td>{{ $total_nb_nsc_others ?? 0 }}</td>
                                        <td>{{ $total_nb_nsc_joint ?? null }}</td>
                                        <td>{{ $total_nb_nsc_total ?? 0 }}</td>

                                        <td>{{ $total_na_bpo_male ?? 0 }}</td>
                                        <td>{{ $total_na_bpo_female ?? 0 }}</td>
                                        <td>{{ $total_na_bpo_others ?? 0 }}</td>
                                        <td>{{ $total_na_bpo_total ?? 0 }}</td>

                                        <td>{{ $total_np_liph_male ?? 0 }}</td>
                                        <td>{{ $total_np_liph_female ?? 0 }}</td>
                                        <td>{{ $total_np_liph_others ?? 0 }}</td>
                                        <td>{{ $total_np_liph_total ?? 0 }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">2. Balance/Outstanding Amount </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="5">Balance of NSC</th>
                                    <th class="text-center" colspan="4">Deposit Balance with BPO</th>
                                    <th class="text-center" colspan="4">Balance of Postal Life Insurance Policies</th>
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Joint</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                @if ($mefNsdDetailsTable2->count())
                                @php
                                $total_bo_nsc_male = 0;
                                $total_bo_nsc_female = 0;
                                $total_bo_nsc_others = 0;
                                $total_bo_nsc_total = 0;
                                $total_bo_nsc_joint = 0;
                                $total_db_bpo_male = 0;
                                $total_db_bpo_female = 0;
                                $total_db_bpo_others = 0;
                                $total_db_bpo_total = 0;
                                $total_bp_lip_male = 0;
                                $total_bp_lip_female = 0;
                                $total_bp_lip_others = 0;
                                $total_bp_lip_total = 0;
                                @endphp
                                    @foreach ($mefNsdDetailsTable2->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_bo_nsc_male += $item->bo_nsc_male??0;
                                            $total_bo_nsc_female += $item->bo_nsc_female??0;
                                            $total_bo_nsc_others += $item->bo_nsc_others??0;
                                            $total_bo_nsc_joint +=  $item->bo_nsc_joint ??0;
                                            $total_bo_nsc_total += $item->bo_nsc_total??0;

                                            $total_db_bpo_male += $item->db_bpo_male??0;
                                            $total_db_bpo_female += $item->db_bpo_female??0;
                                            $total_db_bpo_others += $item->db_bpo_others??0;
                                            $total_db_bpo_total += $item->db_bpo_total??0;

                                            $total_bp_lip_male += $item->bp_lip_male??0;
                                            $total_bp_lip_female += $item->bp_lip_female??0;
                                            $total_bp_lip_others += $item->bp_lip_others??0;
                                            $total_bp_lip_total += $item->bp_lip_total??0;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm ?? null }}</td>
                                            <td>{{ $item->district->area_nm ?? null }}</td>
                                            <td>{{ $item->bo_nsc_male ?? null }}</td>
                                            <td>{{ $item->bo_nsc_female ?? null }}</td>
                                            <td>{{ $item->bo_nsc_others ?? null }}</td>
                                            <td>{{ $item->bo_nsc_joint ?? null }}</td>
                                            <td class="text-bold">{{ $item->bo_nsc_total ?? null }}</td>
                                            <td>{{ $item->db_bpo_male ?? null }}</td>
                                            <td>{{ $item->db_bpo_female ?? null }}</td>
                                            <td>{{ $item->db_bpo_others ?? null }}</td>
                                            <td class="text-bold">{{ $item->db_bpo_total ?? null }}</td>
                                            <td>{{ $item->bp_lip_male ?? null }}</td>
                                            <td>{{ $item->bp_lip_female ?? null }}</td>
                                            <td>{{ $item->bp_lip_others ?? null }}</td>
                                            <td class="text-bold">{{ $item->bp_lip_total ?? null }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-bold">
                                        <td class="text-center" colspan="2">Total</td>
                                        <td>{{ $total_bo_nsc_male ?? 0 }}</td>
                                        <td>{{ $total_bo_nsc_female ?? 0 }}</td>
                                        <td>{{ $total_bo_nsc_others ?? 0 }}</td>
                                        <td>{{ $total_bo_nsc_joint ?? 0 }}</td>
                                        <td>{{ $total_bo_nsc_total ?? 0 }}</td>

                                        <td>{{ $total_db_bpo_male ?? 0 }}</td>
                                        <td>{{ $total_db_bpo_female ?? 0 }}</td>
                                        <td>{{ $total_db_bpo_others ?? 0 }}</td>
                                        <td>{{ $total_db_bpo_total ?? 0 }}</td>

                                        <td>{{ $total_bp_lip_male ?? 0 }}</td>
                                        <td>{{ $total_bp_lip_female ?? 0 }}</td>
                                        <td>{{ $total_bp_lip_others ?? 0 }}</td>
                                        <td>{{ $total_bp_lip_total ?? 0 }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
