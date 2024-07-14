
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">1. Number of Insurance Policy
                                </li>
                              </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="20"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Total Life Insurance Policy</th>
                                    <th class="text-center" colspan="4">Micro Insurance Policy</th>
                                    <th class="text-center" colspan="4">Health Policy</th>
                                    <th class="text-center" rowspan="2">Agricultural Policy (total number)</th>
                                    <th class="text-center" rowspan="2">Non-Life Policy (total number)</th>
                                    <th class="text-center" rowspan="2">Total Insurance Policy</th>
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
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
                                @if ($mefInsuranceDetailsTable1->count())
                                    @php
                                        $total_tlip_male = 0;
                                        $total_tlip_female = 0;
                                        $total_tlip_others = 0;
                                        $total_tlip_total = 0;

                                        $total_mip_male = 0;
                                        $total_mip_female = 0;
                                        $total_mip_others = 0;
                                        $total_mip_total = 0;

                                        $total_hp_male = 0;
                                        $total_hp_female = 0;
                                        $total_hp_others = 0;
                                        $total_hp_total = 0;

                                        $total_ap_total_number = 0;
                                        $total_nfp_total_number = 0;
                                        $total_total_ip = 0;

                                    @endphp

                                    @foreach ($mefInsuranceDetailsTable1->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_tlip_male += $item->tlip_male??0;
                                            $total_tlip_female += $item->tlip_female??0;
                                            $total_tlip_others += $item->tlip_others??0;
                                            $total_tlip_total += $item->tlip_total??0;

                                            $total_mip_male += $item->mip_male??0;
                                            $total_mip_female += $item->mip_female??0;
                                            $total_mip_others += $item->mip_others??0;
                                            $total_mip_total += $item->mip_total??0;

                                            $total_hp_male += $item->hp_male??0;
                                            $total_hp_female += $item->hp_female??0;
                                            $total_hp_others += $item->hp_others??0;
                                            $total_hp_total += $item->hp_total??0;

                                            $total_ap_total_number += $item->ap_total_number??0;
                                            $total_nfp_total_number += $item->nfp_total_number??0;
                                            $total_total_ip += $item->total_ip??0;

                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm ?? null }}</td>
                                            <td>{{ $item->district->area_nm ?? null }}</td>
                                            <td>{{ $item->tlip_male ?? null }}</td>
                                            <td>{{ $item->tlip_female ?? null }}</td>
                                            <td>{{ $item->tlip_others ?? null }}</td>
                                            <td>{{ $item->tlip_total ?? null }}</td>
                                            <td>{{ $item->mip_male ?? null }}</td>
                                            <td>{{ $item->mip_female ?? null }}</td>
                                            <td>{{ $item->mip_others ?? null }}</td>
                                            <td>{{ $item->mip_total ?? null }}</td>
                                            <td>{{ $item->hp_male ?? null }}</td>
                                            <td>{{ $item->hp_female ?? null }}</td>
                                            <td>{{ $item->hp_others ?? null }}</td>
                                            <td>{{ $item->hp_total ?? null }}</td>
                                            <td>{{ $item->ap_total_number ?? null }}</td>
                                            <td>{{ $item->nfp_total_number ?? null }}</td>
                                            <td>{{ $item->total_ip ?? null }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                <tr>
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_tlip_male ?? 0 }}</td>
                                    <td>{{ $total_tlip_female ?? 0 }}</td>
                                    <td>{{ $total_tlip_others ?? 0 }}</td>
                                    <td>{{ $total_tlip_total ?? 0 }}</td>

                                    <td>{{ $total_mip_male ?? 0 }}</td>
                                    <td>{{ $total_mip_female ?? 0 }}</td>
                                    <td>{{ $total_mip_others ?? 0 }}</td>
                                    <td>{{ $total_mip_total ?? 0 }}</td>

                                    <td>{{ $total_hp_male ?? 0 }}</td>
                                    <td>{{ $total_hp_female ?? 0 }}</td>
                                    <td>{{ $total_hp_others ?? 0 }}</td>
                                    <td>{{ $total_hp_total ?? 0 }}</td>

                                    <td>{{ $total_ap_total_number ?? 0 }}</td>
                                    <td>{{ $total_nfp_total_number ?? 0 }}</td>
                                    <td>{{ $total_total_ip ?? 0 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">2. Balance with insurance companies
                                </li>
                              </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="20"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Total Life Insurance Policy</th>
                                    <th class="text-center" colspan="4">Micro Insurance Policy</th>
                                    <th class="text-center" colspan="4">Health Policy</th>
                                    <th class="text-center" rowspan="2">Agricultural Policy (total number)</th>
                                    <th class="text-center" rowspan="2">Non-Life Policy (total number)</th>
                                    <th class="text-center" rowspan="2">Total Insurance Policy</th>
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                @if ($mefInsuranceDetailsTable2->count())
                                    @php
                                        $total_tlip_male = 0;
                                        $total_tlip_female = 0;
                                        $total_tlip_others = 0;
                                        $total_tlip_total = 0;

                                        $total_mip_male = 0;
                                        $total_mip_female = 0;
                                        $total_mip_others = 0;
                                        $total_mip_total = 0;

                                        $total_hp_male = 0;
                                        $total_hp_female = 0;
                                        $total_hp_others = 0;
                                        $total_hp_total = 0;

                                        $total_ap_total_number = 0;
                                        $total_nfp_total_number = 0;
                                        $total_total_ip = 0;

                                    @endphp
                                    @foreach ($mefInsuranceDetailsTable2->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_tlip_male += $item->tlip_male??0;
                                            $total_tlip_female += $item->tlip_female??0;
                                            $total_tlip_others += $item->tlip_others??0;
                                            $total_tlip_total += $item->tlip_total??0;

                                            $total_mip_male += $item->mip_male??0;
                                            $total_mip_female += $item->mip_female??0;
                                            $total_mip_others += $item->mip_others??0;
                                            $total_mip_total += $item->mip_total??0;

                                            $total_hp_male += $item->hp_male??0;
                                            $total_hp_female += $item->hp_female??0;
                                            $total_hp_others += $item->hp_others??0;
                                            $total_hp_total += $item->hp_total??0;

                                            $total_ap_total_number += $item->ap_total_number??0;
                                            $total_nfp_total_number += $item->nfp_total_number??0;
                                            $total_total_ip += $item->total_ip??0;

                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm ?? null }}</td>
                                            <td>{{ $item->district->area_nm ?? null }}</td>
                                            <td>{{ $item->tlip_male ?? null }}</td>
                                            <td>{{ $item->tlip_female ?? null }}</td>
                                            <td>{{ $item->tlip_others ?? null }}</td>
                                            <td>{{ $item->tlip_total ?? null }}</td>
                                            <td>{{ $item->mip_male ?? null }}</td>
                                            <td>{{ $item->mip_female ?? null }}</td>
                                            <td>{{ $item->mip_others ?? null }}</td>
                                            <td>{{ $item->mip_total ?? null }}</td>
                                            <td>{{ $item->hp_male ?? null }}</td>
                                            <td>{{ $item->hp_female ?? null }}</td>
                                            <td>{{ $item->hp_others ?? null }}</td>
                                            <td>{{ $item->hp_total ?? null }}</td>
                                            <td>{{ $item->ap_total_number ?? null }}</td>
                                            <td>{{ $item->nfp_total_number ?? null }}</td>
                                            <td>{{ $item->total_ip ?? null }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_tlip_male ?? 0 }}</td>
                                    <td>{{ $total_tlip_female ?? 0 }}</td>
                                    <td>{{ $total_tlip_others ?? 0 }}</td>
                                    <td>{{ $total_tlip_total ?? 0 }}</td>

                                    <td>{{ $total_mip_male ?? 0 }}</td>
                                    <td>{{ $total_mip_female ?? 0 }}</td>
                                    <td>{{ $total_mip_others ?? 0 }}</td>
                                    <td>{{ $total_mip_total ?? 0 }}</td>

                                    <td>{{ $total_hp_male ?? 0 }}</td>
                                    <td>{{ $total_hp_female ?? 0 }}</td>
                                    <td>{{ $total_hp_others ?? 0 }}</td>
                                    <td>{{ $total_hp_total ?? 0 }}</td>

                                    <td>{{ $total_ap_total_number ?? 0 }}</td>
                                    <td>{{ $total_nfp_total_number ?? 0 }}</td>
                                    <td>{{ $total_total_ip ?? 0 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">3. Automation in Insurance Companies
                                </li>
                              </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16">During July-September 2023</td>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="4">Number of Policy Holder Using Internet Based
                                        Service</th>
                                    <th class="text-center" colspan="4">Number of Policy Holder Paying Premium Through
                                        MFS</th>
                                    <th class="text-center" colspan="4">Number of Policy Holder Paying Premium Through
                                        Bank</th>

                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
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
                                <tr>
                                    <td>{{ $mefInsuranceDetailsTable3->nphuibs_male ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphuibs_female ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphuibs_others ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphuibs_total ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_mfs_male ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_mfs_female ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_mfs_others ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_mfs_total ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_bank_male ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_bank_female ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_bank_others ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable3->nphppt_bank_total ?? null }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">4. Business Centres</li>
                              </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="3">During July-September 2023</td>
                                </tr>
                                <tr>
                                    <th class="text-center">Number of Branch</th>
                                    <th class="text-center">Online Branch</th>
                                </tr>
                                <tr>
                                    <td>{{ $mefInsuranceDetailsTable4->number_of_branch ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable4->online_branch ?? null }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">5. Financial Literacy Programmes
                                    (During the quarter)</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center" colspan="3">Number of FL Program Organized</th>
                                    <th class="text-center" colspan="4">Number of Participants</th>
                                </tr>
                                <tr>
                                    <td>Dhaka</td>
                                    <td>Other Regions</td>
                                    <td>Total</td>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                <tr>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_flpo_dhaka ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_flpo_other_regions ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_flpo_total_regions ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_participants_male ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_participants_female ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_participants_others ?? null }}</td>
                                    <td>{{ $mefInsuranceDetailsTable5->number_of_participants_total ?? null }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class=" mx-auto d-block">
                            <h6 class="card-title pb-2">5. Complaints Query (During the quarter)</h6>
                        </div>
                        <div class="table-responsive">
    
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center">Complaints Received</td>
                                    <td class="text-center">Complaints Resolved</td>
                                    <td class="text-center">Received/Resolved</td>
                                </tr>
                                @if ($mefInsuranceDetailsTable8)
                                    <tr>
                                        <td>{{ $mefInsuranceDetailsTable8->complaints_received ?? null }}</td>
                                        <td>{{ $mefInsuranceDetailsTable8->complaints_resolved ?? null }}</td>
                                        <td>{{ $mefInsuranceDetailsTable8->received_resolved ?? null }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
