
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">1. Number of Account with MFIs
                                </li>
                              </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Number of Total Accounts</th >
                                    <th class="text-center" colspan="4">Number of Deposit Accounts</th >
                                    <th class="text-center" colspan="4">Number of Total Loan Accounts</th >
                                    <th class="text-center" colspan="4">Bank/NBFI-MFI Linkage Loan Accounts</th >
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                </tr>
                                @if ($mefMfisDetailsTable1->count())
                                    @php
                                        $total_nta_male = 0;
                                        $total_nta_female = 0;
                                        $total_nta_others = 0;
                                        $total_nta_total = 0;

                                        $total_nba_male = 0;
                                        $total_nba_female = 0;
                                        $total_nba_others = 0;
                                        $total_nba_total = 0;

                                        $total_ntla_male = 0;
                                        $total_ntla_female = 0;
                                        $total_ntla_others = 0;
                                        $total_ntla_total = 0;

                                        $total_blla_male = 0;
                                        $total_blla_female = 0;
                                        $total_blla_others = 0;
                                        $total_blla_total = 0;
                                    @endphp
                                    @foreach ($mefMfisDetailsTable1->sortBy('division_id') as $item)
                                        @php
                                            $total_nta_male += $item->nta_male??0;
                                            $total_nta_female += $item->nta_female??0;
                                            $total_nta_others += $item->nta_others??0;
                                            $total_nta_total += $item->nta_total??0;

                                            $total_nba_male += $item->nba_male??0;
                                            $total_nba_female += $item->nba_female??0;
                                            $total_nba_others += $item->nba_others??0;
                                            $total_nba_total += $item->nba_total??0;

                                            $total_ntla_male += $item->ntla_male??0;
                                            $total_ntla_female += $item->ntla_female??0;
                                            $total_ntla_others += $item->ntla_others??0;
                                            $total_ntla_total += $item->ntla_total??0;

                                            $total_blla_male += $item->blla_male??0;
                                            $total_blla_female += $item->blla_female??0;
                                            $total_blla_others += $item->blla_others??0;
                                            $total_blla_total += $item->blla_total??0;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->division->area_nm??null }}</td>
                                            <td>{{ $item->district->area_nm??null }}</td>
                                            <td>{{ $item->nta_male??null }}</td>
                                            <td>{{ $item->nta_female??null }}</td>
                                            <td>{{ $item->nta_others??null }}</td>
                                            <td class="text-bold">{{ $item->nta_total??null }}</td>
                                            <td>{{ $item->nba_male??null }}</td>
                                            <td>{{ $item->nba_female??null }}</td>
                                            <td>{{ $item->nba_others??null }}</td>
                                            <td class="text-bold">{{ $item->nba_total??null }}</td>
                                            <td>{{ $item->ntla_male??null }}</td>
                                            <td>{{ $item->ntla_female??null }}</td>
                                            <td>{{ $item->ntla_others??null }}</td>
                                            <td class="text-bold">{{ $item->ntla_total??null }}</td>
                                            <td>{{ $item->blla_male??null }}</td>
                                            <td>{{ $item->blla_female??null }}</td>
                                            <td>{{ $item->blla_others??null }}</td>
                                            <td class="text-bold">{{ $item->blla_total??null }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-bold">
                                        <td class="text-center" colspan="2">Total</td>
                                        <td>{{ $total_nta_male ?? 0 }}</td>
                                        <td>{{ $total_nta_female ?? 0 }}</td>
                                        <td>{{ $total_nta_others ?? 0 }}</td>
                                        <td>{{ $total_nta_total ?? 0 }}</td>
                                        <td>{{ $total_nba_male ?? 0 }}</td>
                                        <td>{{ $total_nba_female ?? 0 }}</td>
                                        <td>{{ $total_nba_others ?? 0 }}</td>
                                        <td>{{ $total_nba_total ?? 0 }}</td>

                                        <td>{{ $total_ntla_male ?? 0 }}</td>
                                        <td>{{ $total_ntla_female ?? 0 }}</td>
                                        <td>{{ $total_ntla_others ?? 0 }}</td>
                                        <td>{{ $total_ntla_total ?? 0 }}</td>

                                        <td>{{ $total_blla_male ?? 0 }}</td>
                                        <td>{{ $total_blla_female ?? 0 }}</td>
                                        <td>{{ $total_blla_others ?? 0 }}</td>
                                        <td>{{ $total_blla_total ?? 0 }}</td>
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
                                <li class="list-group-item text-center font-weight-bold">2. Balance/Outstanding amount with MFIs
                                </li>
                              </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="2">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="4">Number of Total Accounts</th >
                                    <th class="text-center" colspan="4">Number of Deposit Accounts</th >
                                    <th class="text-center" colspan="4">Number of Total Loan Accounts</th >
                                    <th class="text-center" colspan="4">Bank/NBFI-MFI Linkage Loan Accounts</th >
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                    <td>Male</td>
                                    <td>Femate</td>
                                    <td>Others</td>
                                    <td class="text-bold">Total</td>
                                </tr>
                                @if ($mefMfisDetailsTable2->count())
                                    @php
                                        $total_bta_male = 0;
                                        $total_bta_female = 0;
                                        $total_bta_others = 0;
                                        $total_bta_total = 0;

                                        $total_bsa_male = 0;
                                        $total_bsa_female = 0;
                                        $total_bsa_others = 0;
                                        $total_bsa_total = 0;

                                        $total_obtla_male = 0;
                                        $total_obtla_female = 0;
                                        $total_obtla_others = 0;
                                        $total_obtla_total = 0;

                                        $total_oblla_male = 0;
                                        $total_oblla_female = 0;
                                        $total_oblla_others = 0;
                                        $total_oblla_total = 0;
                                    @endphp
                                    @foreach ($mefMfisDetailsTable2->sortBy('division_id')->all() as $item)
                                        @php
                                            $total_bta_male += $item->bta_male??0;
                                            $total_bta_female += $item->bta_female??0;
                                            $total_bta_others += $item->bta_others??0;
                                            $total_bta_total += $item->bta_total??0;

                                            $total_bsa_male += $item->bsa_male??0;
                                            $total_bsa_female += $item->bsa_female??0;
                                            $total_bsa_others += $item->bsa_others??0;
                                            $total_bsa_total += $item->bsa_total??0;

                                            $total_obtla_male += $item->obtla_male??0;
                                            $total_obtla_female += $item->obtla_female??0;
                                            $total_obtla_others += $item->obtla_others??0;
                                            $total_obtla_total += $item->obtla_total??0;

                                            $total_oblla_male += $item->oblla_male??0;
                                            $total_oblla_female += $item->oblla_female??0;
                                            $total_oblla_others += $item->oblla_others??0;
                                            $total_oblla_total += $item->oblla_total??0;
                                        @endphp
                                    <tr>
                                        <td>{{ $item->division->area_nm??null }}</td>
                                        <td>{{ $item->district->area_nm??null }}</td>
                                        <td>{{ $item->bta_male??null }}</td>
                                        <td>{{ $item->bta_female??null }}</td>
                                        <td>{{ $item->bta_others??null }}</td>
                                        <td class="text-bold">{{ $item->bta_total??null }}</td>
                                        <td>{{ $item->bsa_male??null }}</td>
                                        <td>{{ $item->bsa_female??null }}</td>
                                        <td>{{ $item->bsa_others??null }}</td>
                                        <td class="text-bold">{{ $item->bsa_total??null }}</td>
                                        <td>{{ $item->obtla_male??null }}</td>
                                        <td>{{ $item->obtla_female??null }}</td>
                                        <td>{{ $item->obtla_others??null }}</td>
                                        <td class="text-bold">{{ $item->obtla_total??null }}</td>
                                        <td>{{ $item->oblla_male??null }}</td>
                                        <td>{{ $item->oblla_female??null }}</td>
                                        <td>{{ $item->oblla_others??null }}</td>
                                        <td class="text-bold">{{ $item->oblla_total??null }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                                <tr class="text-bold">
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_bta_male ?? 0 }}</td>
                                    <td>{{ $total_bta_female ?? 0 }}</td>
                                    <td>{{ $total_bta_others ?? 0 }}</td>
                                    <td>{{ $total_bta_total ?? 0 }}</td>
                                    <td>{{ $total_bsa_male ?? 0 }}</td>
                                    <td>{{ $total_bsa_female ?? 0 }}</td>
                                    <td>{{ $total_bsa_others ?? 0 }}</td>
                                    <td>{{ $total_bsa_total ?? 0 }}</td>

                                    <td>{{ $total_obtla_male ?? 0 }}</td>
                                    <td>{{ $total_obtla_female ?? 0 }}</td>
                                    <td>{{ $total_obtla_others ?? 0 }}</td>
                                    <td>{{ $total_obtla_total ?? 0 }}</td>

                                    <td>{{ $total_oblla_male ?? 0 }}</td>
                                    <td>{{ $total_oblla_female ?? 0 }}</td>
                                    <td>{{ $total_oblla_others ?? 0 }}</td>
                                    <td>{{ $total_oblla_total ?? 0 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">3. Automation in MFIs</li>
                              </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center" colspan="4">Number of Account Using Internet/Mobile App Based Service</th>
                                    <th class="text-center" colspan="4">Number of Borrower Receiving Loan Through MFS</th>
                                    <th class="text-center" colspan="4">Number of Borrower Paying Installment Through MFS</th>

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
                                    <td>{{ $mefMfisDetailsTable3->naui_male??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->naui_female??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->naui_others??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->naui_total??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbrl_male??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbrl_female??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbrl_others??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbrl_total??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbpi_male??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbpi_female??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbpi_others??null}}</td>
                                    <td>{{ $mefMfisDetailsTable3->nbpi_total??null}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">4. MFI Related Information</li>
                              </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Number of MFIs</th>
                                    <th>Number of Branch</th>
                                    <th>Number of Online Branch</th>
                                </tr>
                                <tr>
                                    <td>{{ $mefMfisDetailsTable4->number_of_mfis??null}}</td>
                                    <td>{{ $mefMfisDetailsTable4->number_of_branch??null}}</td>
                                    <td>{{ $mefMfisDetailsTable4->number_of_online_branch??null}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">5. Non Performing Loans</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <th></th>
                                    <th>Unclassified</th>
                                    <th>classified</th>
                                </tr>

                                @if ($mefMfisDetailsTable5->count())
                                    @foreach ($mefMfisDetailsTable5 as $item)
                                        <tr>
                                            <td>{{ $item->mefMfisLabel->name??null }}</td>
                                            <td>{{ $item->unclassified??null }}</td>
                                            <td>{{ $item->classified??null }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">6. Foreign Remittance</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="9">During the quarter</td>
                                </tr>
                                <tr>
                                    <th rowspan="2"></th>
                                    <th class="text-center" colspan="4">Number of Transaction</th>
                                    <th class="text-center" colspan="4">Amount of Transaction</th>
                                </tr>
                                <tr>
                                    <td class="text-center">Male</td>
                                    <td class="text-center">female</td>
                                    <td class="text-center">Others</td>
                                    <td class="text-center">Total</td>
                                    <td class="text-center">Male</td>
                                    <td class="text-center">female</td>
                                    <td class="text-center">Others</td>
                                    <td class="text-center">Total</td>
                                </tr>
                                <tr>
                                    <td>{{ $mefMfisDetailsTable6->mefMfisLabel->name ??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->nt_male??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->nt_female??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->nt_others??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->nt_total??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->at_male??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->at_female??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->at_others??null }}</td>
                                    <td>{{ $mefMfisDetailsTable6->at_total??null }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">7. Financial Literacy Programmes (During the quarter)</li>
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
                                    <td>{{ $mefMfisDetailsTable7->nflpo_dhaka??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->nflpo_others??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->nflpo_total??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->np_male??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->np_female??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->np_others??null}}</td>
                                    <td>{{ $mefMfisDetailsTable7->np_total??null}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class=" mx-auto d-block">
                            <h6 class="card-title pb-2">8. Complaints Query (During the quarter)</h6>
                        </div>
                        <div class="table-responsive">
    
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center">Complaints Received</td>
                                    <td class="text-center">Complaints Resolved</td>
                                    <td class="text-center">Received/Resolved</td>
                                </tr>
                                @if ($mefMfisDetailsTable8)
                                    <tr>
                                        <td>{{ $mefMfisDetailsTable8->complaints_received ?? null }}</td>
                                        <td>{{ $mefMfisDetailsTable8->complaints_resolved ?? null }}</td>
                                        <td>{{ $mefMfisDetailsTable8->received_resolved ?? null }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
