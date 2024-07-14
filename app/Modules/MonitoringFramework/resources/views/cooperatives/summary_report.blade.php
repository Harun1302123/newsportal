
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">1. Number of Account with Cooperative Societies
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="20"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Total Number of Member</th >
                                    <th class="text-center" colspan="4">Total Number of Accounts</th >
                                    <th class="text-center" colspan="4">Number of Savings Accounts</th >
                                    <th class="text-center" colspan="4">Number of Loan Accounts</th >
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
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                @if ($mefCooperativesDetailsTable1->count())
                                    @php
                                        $total_tnm_male = 0;
                                        $total_tnm_female = 0;
                                        $total_tnm_others = 0;
                                        $total_tnm_total = 0;

                                        $total_tna_male = 0;
                                        $total_tna_female = 0;
                                        $total_tna_others = 0;
                                        $total_tna_total = 0;

                                        $total_nsa_male = 0;
                                        $total_nsa_female = 0;
                                        $total_nsa_others = 0;
                                        $total_nsa_total = 0;

                                        $total_nla_male = 0;
                                        $total_nla_female = 0;
                                        $total_nla_others = 0;
                                        $total_nla_total = 0;
                                    @endphp
                                    @foreach ($mefCooperativesDetailsTable1->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_tnm_male += $item->tnm_male??0;
                                            $total_tnm_female += $item->tnm_female??0;
                                            $total_tnm_others += $item->tnm_others??0;
                                            $total_tnm_total += $item->tnm_total??0;

                                            $total_tna_male += $item->tna_male??0;
                                            $total_tna_female += $item->tna_female??0;
                                            $total_tna_others += $item->tna_others??0;
                                            $total_tna_total += $item->tna_total??0;

                                            $total_nsa_male += $item->nsa_male??0;
                                            $total_nsa_female += $item->nsa_female??0;
                                            $total_nsa_others += $item->nsa_others??0;
                                            $total_nsa_total += $item->nsa_total??0;

                                            $total_nla_male += $item->nla_male??0;
                                            $total_nla_female += $item->nla_female??0;
                                            $total_nla_others += $item->nla_others??0;
                                            $total_nla_total += $item->nla_total??0;

                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm??null }}</td>
                                            <td>{{ $item->district->area_nm??null }}</td>
                                            {{-- ob@1 must use null handle like $item->tnm_male??null for whole file --}}
                                            <td>{{ $item->tnm_male }}</td>
                                            <td>{{ $item->tnm_female }}</td>
                                            <td> {{ $item->tnm_others  }} </td>
                                            <td>{{ $item->tnm_total  }}</td>

                                            <td>{{ $item->tna_male }}</td>
                                            <td>{{ $item->tna_female }}</td>
                                            <td>{{ $item->tna_others }}</td>
                                            <td>{{ $item->tna_total }}</td>

                                            <td>{{ $item->nsa_male }}</td>
                                            <td>{{ $item->nsa_female }}</td>
                                            <td>{{ $item->nsa_others }}</td>
                                            <td>{{ $item->nsa_total }}</td>

                                            <td>{{ $item->nla_male }}</td>
                                            <td>{{ $item->nla_female }}</td>
                                            <td>{{ $item->nla_others }}</td>
                                            <td>{{ $item->nla_total }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                <tr>
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_tnm_male }}</td>
                                    <td>{{ $total_tnm_female }}</td>
                                    <td>{{ $total_tnm_others }}</td>
                                    <td>{{ $total_tnm_total }}</td>

                                    <td>{{ $total_tna_male }}</td>
                                    <td>{{ $total_tna_female }}</td>
                                    <td>{{ $total_tna_others }}</td>
                                    <td>{{ $total_tna_total }}</td>

                                    <td>{{ $total_nsa_male }}</td>
                                    <td>{{ $total_nsa_female }}</td>
                                    <td>{{ $total_nsa_others }}</td>
                                    <td>{{ $total_nsa_total }}</td>

                                    <td>{{ $total_nla_male }}</td>
                                    <td>{{ $total_nla_female }}</td>
                                    <td>{{ $total_nla_others }}</td>
                                    <td>{{ $total_nla_total }}</td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">2. Balance/Outstanding amount with Cooperative Societies
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="20"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Deposit Balance of Total Member</th >
                                    <th class="text-center" colspan="4">Balance with Total Accounts</th >
                                    <th class="text-center" colspan="4">Deposit Balance of Savings Accounts</th >
                                    <th class="text-center" colspan="4">Outstanding Balance of Loan Accounts</th >
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
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Total</td>
                                </tr>
                                @if ($mefCooperativesDetailsTable2->count())
                                    @php
                                        $total_dbtm_male = 0;
                                        $total_dbtm_female = 0;
                                        $total_dbtm_others = 0;
                                        $total_dbtm_total = 0;

                                        $total_bta_male = 0;
                                        $total_bta_female = 0;
                                        $total_bta_others = 0;
                                        $total_bta_total = 0;

                                        $total_dbsa_male = 0;
                                        $total_dbsa_female = 0;
                                        $total_dbsa_others = 0;
                                        $total_dbsa_total = 0;

                                        $total_obla_male = 0;
                                        $total_obla_female = 0;
                                        $total_obla_others = 0;
                                        $total_obla_total = 0;
                                    @endphp
                                    @foreach ($mefCooperativesDetailsTable2->sortBy('division_id')->all() as $item1)
                                        @php
                                            $total_dbtm_male += $item1->dbtm_male??0;
                                            $total_dbtm_female += $item1->dbtm_female??0;
                                            $total_dbtm_others += $item1->dbtm_others??0;
                                            $total_dbtm_total += $item1->dbtm_total??0;

                                            $total_bta_male += $item1->bta_male??0;
                                            $total_bta_female += $item1->bta_female??0;
                                            $total_bta_others += $item1->bta_others??0;
                                            $total_bta_total += $item1->bta_total??0;

                                            $total_dbsa_male += $item1->dbsa_male??0;
                                            $total_dbsa_female += $item1->dbsa_female??0;
                                            $total_dbsa_others += $item1->dbsa_others??0;
                                            $total_dbsa_total += $item1->dbsa_total??0;

                                            $total_obla_male += $item1->obla_male??0;
                                            $total_obla_female += $item1->obla_female??0;
                                            $total_obla_others += $item1->obla_others??0;
                                            $total_obla_total += $item1->obla_total??0;
                                        @endphp

                                        <tr>
                                            <td>{{ $item1->division->area_nm??null }}</td>
                                            <td>{{ $item1->district->area_nm??null }}</td>
                                            <td>{{ $item1->dbtm_male }}</td>
                                            <td>{{ $item1->dbtm_female }}</td>
                                            <td> {{ $item1->dbtm_others  }} </td>
                                            <td>{{ $item1->dbtm_total  }}</td>

                                            <td>{{ $item1->bta_male }}</td>
                                            <td>{{ $item1->bta_female }}</td>
                                            <td>{{ $item1->bta_others }}</td>
                                            <td>{{ $item1->bta_total }}</td>

                                            <td>{{ $item1->dbsa_male }}</td>
                                            <td>{{ $item1->dbsa_female }}</td>
                                            <td>{{ $item1->dbsa_others }}</td>
                                            <td>{{ $item1->dbsa_total }}</td>

                                            <td>{{ $item1->obla_male }}</td>
                                            <td>{{ $item1->obla_female }}</td>
                                            <td>{{ $item1->obla_others }}</td>
                                            <td>{{ $item1->obla_total }}</td>
                                        </tr>


                                    @endforeach
                                @endif

                                <tr>
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_dbtm_male }}</td>
                                    <td>{{ $total_dbtm_female }}</td>
                                    <td>{{ $total_dbtm_others }}</td>
                                    <td>{{ $total_dbtm_total }}</td>

                                    <td>{{ $total_bta_male }}</td>
                                    <td>{{ $total_bta_female }}</td>
                                    <td>{{ $total_bta_others }}</td>
                                    <td>{{ $total_bta_total }}</td>

                                    <td>{{ $total_dbsa_male }}</td>
                                    <td>{{ $total_dbsa_female }}</td>
                                    <td>{{ $total_dbsa_others }}</td>
                                    <td>{{ $total_dbsa_total }}</td>

                                    <td>{{ $total_obla_male }}</td>
                                    <td>{{ $total_obla_female }}</td>
                                    <td>{{ $total_obla_others }}</td>
                                    <td>{{ $total_obla_total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">3. Automation in Cooperatives</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16">During July-September 2023</td>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="4">Number of Account Using Internet/Mobile App Based Service</th>
                                    <th class="text-center" colspan="4">Number of Borrower Receiving Loan Through MFS</th>
                                    <th class="text-center" colspan="4">Number of Borrower Paying Installment Through MFS</th>

                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <th>Total</th>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <th>Total</th>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <td>{{ $mefCooperativesDetailsTable3->maui_male }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->maui_female }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->maui_others }}</td>
                                    <th>{{ $mefCooperativesDetailsTable3->maui_total }}</th>
                                    <td>{{ $mefCooperativesDetailsTable3->brlt_mfs_male }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->brlt_mfs_female }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->brlt_mfs_others }}</td>
                                    <th>{{ $mefCooperativesDetailsTable3->brlt_total }}</th>
                                    <td>{{ $mefCooperativesDetailsTable3->nbpit_mfs_male }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->nbpit_mfs_female }}</td>
                                    <td>{{ $mefCooperativesDetailsTable3->nbpit_mfs_others }}</td>
                                    <th>{{ $mefCooperativesDetailsTable3->nbpit_total }}</th>
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
                                    <th class="text-center" >Number of Cooperatives</th>
                                    <th class="text-center" >Number of Branch</th>
                                    <th class="text-center">Number of Online Branch</th>

                                </tr>
                                <tr>
                                    <td>{{ $mefCooperativesDetailsTable4->noc }}</td>
                                    <td>{{ $mefCooperativesDetailsTable4->nob }}</td>
                                    <td>{{ $mefCooperativesDetailsTable4->noob }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">5. Financial Literacy Programmes (During the quarter)</li>
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
                                    <td>{{ $mefCooperativesDetailsTable5->nflpo_dhaka }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nflpo_other_region }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nflpo_total }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nop_male }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nop_female }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nop_others }}</td>
                                    <td>{{ $mefCooperativesDetailsTable5->nop_total }}</td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">6. Complaints Query (During the quarter)</li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center">Complaints Received</td>
                                    <td class="text-center">Complaints Resolved</td>
                                    <td class="text-center">Received/Resolved</td>
                                </tr>
                                @if ($mefCooperativesDetailsTable8)
                                    <tr>
                                        <td>{{ $mefCooperativesDetailsTable8->complaints_received ?? null }}</td>
                                        <td>{{ $mefCooperativesDetailsTable8->complaints_resolved ?? null }}</td>
                                        <td>{{ $mefCooperativesDetailsTable8->received_resolved ?? null }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

