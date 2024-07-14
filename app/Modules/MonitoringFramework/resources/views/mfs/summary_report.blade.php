
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">1. Account Related Information
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2"></th>
                                    <td class="text-center" colspan="3">Male</td>
                                    <td class="text-center" colspan="3">Female</td>
                                    <td class="text-center" colspan="3">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                </tr>
                                <tr>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                </tr>

                                @if ($mefMfsDetailsTable1->count())
                                    @foreach ($mefMfsDetailsTable1->sortBy('mef_mfs_label_id') as $item)
                                        <tr>
                                            <th>{{ $item->mefMfsLabel->name }}</th>
                                            <td>{{ $item->male_rural }}</td>
                                            <td>{{ $item->male_urban }}</td>
                                            <th>{{ $item->male_total }}</th>

                                            <td>{{ $item->female_rural }}</td>
                                            <td>{{ $item->female_urban }}</td>
                                            <th>{{ $item->female_total }}</th>

                                            <td>{{ $item->others_rural }}</td>
                                            <td>{{ $item->others_urban }}</td>
                                            <th>{{ $item->others_total }}</th>

                                            <td>{{ $item->total_rural }}</td>
                                            <td>{{ $item->total_urban }}</td>
                                            <th>{{ intval($item->total_rural) + intval($item->total_urban) }}</th>
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
                                <li class="list-group-item text-center font-weight-bold">2. Transaction Information (Number of Transaction)</li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16">During the Quarter</td>
                                </tr>
                                <tr>
                                    <th rowspan="2"></th>
                                    <td class="text-center" colspan="3">Male</td>
                                    <td class="text-center" colspan="3">Female</td>
                                    <td class="text-center" colspan="3">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                </tr>
                                <tr>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                </tr>
                                @if ($mefMfsDetailsTable2->count())
                                    @foreach ($mefMfsDetailsTable2->sortBy('mef_mfs_label_id') as $item)
                                        <tr>
                                            <th>{{ $item->mefMfsLabel->name }}</th>
                                            <td>{{ $item->male_rural }}</td>
                                            <td>{{ $item->male_urban }}</td>
                                            <th>{{ $item->male_total }}</th>

                                            <td>{{ $item->female_rural }}</td>
                                            <td>{{ $item->female_urban }}</td>
                                            <th>{{ $item->female_total }}</th>

                                            <td>{{ $item->others_rural }}</td>
                                            <td>{{ $item->others_urban }}</td>
                                            <th>{{ $item->others_total }}</th>

                                            <td>{{ $item->total_rural }}</td>
                                            <td>{{ $item->total_urban }}</td>
                                            <th>{{ intval($item->total_rural) + intval($item->total_urban) }}</th>
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
                                <li class="list-group-item text-center font-weight-bold">3. Transaction Information (Volume of Transaction)</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16">During the Quarter</td>
                                </tr>
                                <tr>
                                    <th rowspan="2"></th>
                                    <td class="text-center" colspan="3">Male</td>
                                    <td class="text-center" colspan="3">Female</td>
                                    <td class="text-center" colspan="3">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                </tr>
                                <tr>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                </tr>
                                @if ($mefMfsDetailsTable3->count())
                                    @foreach ($mefMfsDetailsTable3->sortBy('mef_mfs_label_id') as $item)
                                        <tr>
                                            <th>{{ $item->mefMfsLabel->name }}</th>
                                            <td>{{ $item->male_rural }}</td>
                                            <td>{{ $item->male_urban }}</td>
                                            <th>{{ $item->male_total }}</th>

                                            <td>{{ $item->female_rural }}</td>
                                            <td>{{ $item->female_urban }}</td>
                                            <th>{{ $item->female_total }}</th>

                                            <td>{{ $item->others_rural }}</td>
                                            <td>{{ $item->others_urban }}</td>
                                            <th>{{ $item->others_total }}</th>

                                            <td>{{ $item->total_rural }}</td>
                                            <td>{{ $item->total_urban }}</td>
                                            <th>{{ intval($item->total_rural) + intval($item->total_urban) }}</th>
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
                                <li class="list-group-item text-center font-weight-bold">4. Foreign Remittance</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="25">During the quarter</td>
                                </tr>
                                <tr>
                                    <th rowspan="3"></th>
                                    <td class="text-center" colspan="9">Number of Transaction</td>
                                    <td class="text-center" colspan="9">Volume of Transaction (Amount in USD)</td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="2">Male</td>
                                    <td class="text-center" colspan="2">female</td>
                                    <td class="text-center" colspan="2">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                    <td class="text-center" colspan="2">Male</td>
                                    <td class="text-center" colspan="2">female</td>
                                    <td class="text-center" colspan="2">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                </tr>
                                <tr>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                </tr>
                                @if ($mefMfsDetailsTable4->count())
                                  @php
                                    $item = $mefMfsDetailsTable4;
                                  @endphp
                                        <tr>
                                            <th>{{ $item->mefMfsLabel->name }}</th>

                                            <td>{{ $item->nt_male_rural }}</td>
                                            <td>{{ $item->nt_male_urban }}</td>

                                            <td>{{ $item->nt_female_rural }}</td>
                                            <td>{{ $item->nt_female_urban }}</td>

                                            <td>{{ $item->nt_others_rural }}</td>
                                            <td>{{ $item->nt_others_urban }}</td>

                                            <td>{{ $item->nt_total_rural }}</td>
                                            <td>{{ $item->nt_total_urban }}</td>
                                            <th>{{ intval($item->nt_total_rural) + intval($item->nt_total_urban) }}</th>

                                            <td>{{ $item->vt_male_rural }}</td>
                                            <td>{{ $item->vt_male_urban }}</td>

                                            <td>{{ $item->vt_female_rural }}</td>
                                            <td>{{ $item->vt_female_urban }}</td>

                                            <td>{{ $item->vt_others_rural }}</td>
                                            <td>{{ $item->vt_others_urban }}</td>

                                            <td>{{ $item->vt_total_rural }}</td>
                                            <td>{{ $item->vt_total_urban }}</td>
                                            <th>{{ intval($item->vt_total_rural) + intval($item->vt_total_urban) }}</th>
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
                                <li class="list-group-item text-center font-weight-bold">5. Agent Information</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-right" colspan="16"> </td>
                                </tr>
                                <tr>
                                    <th rowspan="2"></th>
                                    <td class="text-center" colspan="2">Male</td>
                                    <td class="text-center" colspan="2">Female</td>
                                    <td class="text-center" colspan="2">Others</td>
                                    <td class="text-center" colspan="3">Total</td>
                                </tr>
                                <tr>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <td>Rural</td>
                                    <td>Urban</td>
                                    <th>Total</th>
                                </tr>
                                @if ($mefMfsDetailsTable5->count())
                                    @php
                                        $item = $mefMfsDetailsTable5;
                                     @endphp
                                        <tr>
                                            <th>{{ $item->mefMfsLabel->name }}</th>
                                            <td>{{ $item->male_rural }}</td>
                                            <td>{{ $item->male_urban }}</td>

                                            <td>{{ $item->female_rural }}</td>
                                            <td>{{ $item->female_urban }}</td>

                                            <td>{{ $item->others_rural }}</td>
                                            <td>{{ $item->others_urban }}</td>

                                            <td>{{ $item->total_rural }}</td>
                                            <td>{{ $item->total_urban }}</td>
                                            <th>{{ intval($item->total_rural) + intval($item->total_urban) }}</th>
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
                                <li class="list-group-item text-center font-weight-bold">6. Financial Literacy Programmes (During the quarter)</li>
                            </ul>

                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center" colspan="3">Number of FL Program Organized</td>
                                    <td class="text-center" colspan="4">Number of Participants</td>
                                </tr>
                                <tr>
                                    <td>Dhaka</td>
                                    <td>Other Regions</td>
                                    <th>Total</th>
                                    <td>Male</td>
                                    <td>Female</td>
                                    <td>Others</td>
                                    <th>Total</th>
                                </tr>
                                @if ($mefMfsDetailsTable6->count())
                                    @php
                                        $item = $mefMfsDetailsTable6;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->nflpo_dhaka }}</td>
                                        <td>{{ $item->nflpo_other_regions }}</td>
                                        <th>{{ $item->nflpo_total }}</th>

                                        <td>{{ $item->np_male }}</td>
                                        <td>{{ $item->np_female }}</td>
                                        <td>{{ $item->np_others }}</td>
                                        <th>{{ $item->np_total }}</th>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class=" mx-auto d-block">
                            <h6 class="card-title pb-2">7. Complaints Query (During the quarter)</h6>
                        </div>
                        <div class="table-responsive">
    
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center">Complaints Received</td>
                                    <td class="text-center">Complaints Resolved</td>
                                    <td class="text-center">Received/Resolved</td>
                                </tr>
                                @if ($mefMfsDetailsTable8)
                                    <tr>
                                        <td>{{ $mefMfsDetailsTable8->complaints_received ?? null }}</td>
                                        <td>{{ $mefMfsDetailsTable8->complaints_resolved ?? null }}</td>
                                        <td>{{ $mefMfsDetailsTable8->received_resolved ?? null }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
