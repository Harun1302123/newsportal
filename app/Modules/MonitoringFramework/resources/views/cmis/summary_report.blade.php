
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">1. Account Related Information
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="20"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2" colspan="1">Divison</th>
                                    <th rowspan="2">District</th>
                                    <th class="text-center" colspan="5">Number of BO Accounts</th >
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Institutional</td>
                                    <td>Total</td>
                                </tr>
                                @if ($MefCmisDetailsTable1->count())
                                    @php
                                        $total_nbo_accounts_male = 0;
                                        $total_nbo_accounts_female = 0;
                                        $total_nbo_accounts_others = 0;
                                        $total_nbo_accounts_institutional = 0;
                                        $total_nbo_total = 0;
                                    @endphp
                                @foreach($MefCmisDetailsTable1->sortBy('district_id')->sortBy('division_id') as $item)
                                        @php
                                            $total_nbo_accounts_male = $total_nbo_accounts_male + $item->nbo_accounts_male;
                                            $total_nbo_accounts_female = $total_nbo_accounts_female + $item->nbo_accounts_female;
                                            $total_nbo_accounts_others = $total_nbo_accounts_others + $item->nbo_accounts_others;
                                            $total_nbo_accounts_institutional = $total_nbo_accounts_institutional + $item->nbo_accounts_institutional;
                                            $total_nbo_total = $total_nbo_total + $item->nbo_total;
                                        @endphp
                                        <tr>
                                            <td>{{$item->division->area_nm}}</td>
                                            <td>{{$item->district->area_nm}}</td>
                                            <td>{{$item->nbo_accounts_male}}</td>
                                            <td>{{$item->nbo_accounts_female}}</td>
                                            <td>{{$item->nbo_accounts_others}}</td>
                                            <td>{{$item->nbo_accounts_institutional}}</td>
                                            <td>{{$item->nbo_total}}</td>
                                        </tr>
                                @endforeach
                                @endif

                                <tr>
                                    <td class="text-center" colspan="2">Total</td>
                                    <td>{{ $total_nbo_accounts_male }}</td>
                                    <td>{{ $total_nbo_accounts_female }}</td>
                                    <td>{{ $total_nbo_accounts_others }}</td>
                                    <td>{{ $total_nbo_accounts_institutional }}</td>
                                    <td>{{ $total_nbo_total }}</td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">2. Automation Related Information</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="5"> </td>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="5">Number of BO Accounts Using Mobile App</th>
                                </tr>
                                <tr>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <td>Institutional</td>
                                </tr>
                                <tr>
                                    <td>{{ $MefCmisDetailsTable2->number_of_boauma_male ?? 0 }}</td>
                                    <td>{{ $MefCmisDetailsTable2->number_of_boauma_female ?? 0 }}</td>
                                    <td>{{ $MefCmisDetailsTable2->number_of_boauma_others ?? 0 }}</td>
                                    <td>{{ $MefCmisDetailsTable2->number_of_boauma_institutional ?? 0 }}</td>
                                    <td>{{ $MefCmisDetailsTable2->total ?? 0 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">3. Transaction Information (Volume of Transaction)</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="4"> </td>
                                </tr>
                                <tr>
                                    <th>Type of CMI</th>
                                    <td class="text-center">Number of CMIs</td>
                                    <td class="text-center">Number of Branch</td>
                                    <td class="text-center">Number of Online Branch</td>
                                </tr>
                                @if($MefCmisDetailsTable3->count())
                                @php
                                $total_number_of_cmis = 0;
                                $total_number_of_branch = 0;
                                $total_number_of_online_branch = 0;
                                @endphp
                                    @foreach($MefCmisDetailsTable3 as $item3)
                                    @php
                                    $total_number_of_cmis =  $total_number_of_cmis + $item3->number_of_cmis;
                                    $total_number_of_branch =  $total_number_of_branch + $item3->number_of_branch;
                                    $total_number_of_online_branch = $total_number_of_online_branch + $item3->number_of_online_branch;
                                    @endphp
                                        <tr>
                                            <td>{{ $item3->mefCmisLabel->name }}</td>
                                            <td>{{ $item3->number_of_cmis }}</td>
                                            <td>{{ $item3->number_of_branch }}</td>
                                            <td>{{ $item3->number_of_online_branch }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="text-center">Total</td>
                                    <td>{{ $total_number_of_cmis }}</td>
                                    <td>{{ $total_number_of_branch }}</td>
                                    <td>{{ $total_number_of_online_branch }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">4. Financial Literacy Programmes (During the quarter)</li>
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
                                    <td>{{ $MefCmisDetailsTable4->number_of_flp_organize_dhaka }}</td>
                                    <td>{{ $MefCmisDetailsTable4->number_of_flp_organize_other_region }}</td>
                                    <td>{{ $MefCmisDetailsTable4->nflpo_total }}</td>
                                    <td>{{ $MefCmisDetailsTable4->number_of_participation_male }}</td>
                                    <td>{{ $MefCmisDetailsTable4->number_of_participation_female }}</td>
                                    <td>{{ $MefCmisDetailsTable4->number_of_participation_others }}</td>
                                    <td>{{ $MefCmisDetailsTable4->nop_total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">8. Complaints Query (During the quarter)</li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center">Complaints Received</td>
                                    <td class="text-center">Complaints Resolved</td>
                                    <td class="text-center">Received/Resolved</td>
                                </tr>
                                @if ($mefCmisDetailsTable8)
                                    <tr>
                                        <td>{{ $mefCmisDetailsTable8->complaints_received ?? null }}</td>
                                        <td>{{ $mefCmisDetailsTable8->complaints_resolved ?? null }}</td>
                                        <td>{{ $mefCmisDetailsTable8->received_resolved ?? null }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
