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

                @if ($master_data->mefMfsDetailsTable1->count())
                    @foreach ($master_data->mefMfsDetailsTable1 as $item)
                        <tr>
                            <td>{{ $item->mefMfsLabel->name ?? 0 }}</td>
                            <td>{{ $item->male_rural ?? 0 }}</td>
                            <td>{{ $item->male_urban ?? 0 }}</td>
                            <td>{{ $item->male_total ?? 0 }}</td>
                            <td>{{ $item->female_rural ?? 0 }}</td>
                            <td>{{ $item->female_urban ?? 0 }}</td>
                            <td>{{ $item->female_total ?? 0 }}</td>
                            <td>{{ $item->others_rural ?? 0 }}</td>
                            <td>{{ $item->others_urban ?? 0 }}</td>
                            <td>{{ $item->others_total ?? 0 }}</td>
                            <td>{{ $item->total_rural ?? 0 }}</td>
                            <td>{{ $item->total_urban ?? 0 }}</td>
                            <td>{{ intval($item->total_rural ?? 0) + intval($item->total_urban ?? 0) }}</td>
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
                <li class="list-group-item text-center font-weight-bold">2. Transaction Information (Number of
                    Transaction)</li>
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
                @if ($master_data->mefMfsDetailsTable2->count())
                    @foreach ($master_data->mefMfsDetailsTable2 as $item)
                        <tr>
                            <td>{{ $item->mefMfsLabel->name ?? 0 }}</td>
                            <td>{{ $item->male_rural ?? 0 }}</td>
                            <td>{{ $item->male_urban ?? 0 }}</td>
                            <td>{{ $item->male_total ?? 0 }}</td>
                            <td>{{ $item->female_rural ?? 0 }}</td>
                            <td>{{ $item->female_urban ?? 0 }}</td>
                            <td>{{ $item->female_total ?? 0 }}</td>
                            <td>{{ $item->others_rural ?? 0 }}</td>
                            <td>{{ $item->others_urban ?? 0 }}</td>
                            <td>{{ $item->others_total ?? 0 }}</td>
                            <td>{{ $item->total_rural ?? 0 }}</td>
                            <td>{{ $item->total_urban ?? 0 }}</td>
                            <td>{{ intval($item->total_rural ?? 0) + intval($item->total_urban ?? 0) }}</td>
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
                <li class="list-group-item text-center font-weight-bold">3. Transaction Information (Volume of
                    Transaction)</li>
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
                @if ($master_data->mefMfsDetailsTable3->count())
                    @foreach ($master_data->mefMfsDetailsTable3 as $item)
                        <tr>
                            <td>{{ $item->mefMfsLabel->name ?? 0 }}</td>
                            <td>{{ $item->male_rural ?? 0 }}</td>
                            <td>{{ $item->male_urban ?? 0 }}</td>
                            <td>{{ $item->male_total ?? 0 }}</td>
                            <td>{{ $item->female_rural ?? 0 }}</td>
                            <td>{{ $item->female_urban ?? 0 }}</td>
                            <td>{{ $item->female_total ?? 0 }}</td>
                            <td>{{ $item->others_rural ?? 0 }}</td>
                            <td>{{ $item->others_urban ?? 0 }}</td>
                            <td>{{ $item->others_total ?? 0 }}</td>
                            <td>{{ $item->total_rural ?? 0 }}</td>
                            <td>{{ $item->total_urban ?? 0 }}</td>
                            <td>{{ intval($item->total_rural ?? 0) + intval($item->total_urban ?? 0) }}</td>
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

                @if ($master_data->mefMfsDetailsTable4->count())
                    @foreach ($master_data->mefMfsDetailsTable4 as $item)
                        <tr>
                            <td>{{ $item->mefMfsLabel->name ?? 0 }}</td>
                            <td>{{ $item->nt_male_rural ?? 0 }}</td>
                            <td>{{ $item->nt_male_urban ?? 0 }}</td>
                            <td>{{ $item->nt_female_rural ?? 0 }}</td>
                            <td>{{ $item->nt_female_urban ?? 0 }}</td>
                            <td>{{ $item->nt_others_rural ?? 0 }}</td>
                            <td>{{ $item->nt_others_urban ?? 0 }}</td>
                            <td>{{ $item->nt_total_rural ?? 0 }}</td>
                            <td>{{ $item->nt_total_urban ?? 0 }}</td>
                            <td>{{ intval($item->nt_total_rural ?? 0) + intval($item->nt_total_urban ?? 0) }}</td>

                            <td>{{ $item->vt_male_rural ?? 0 }}</td>
                            <td>{{ $item->vt_male_urban ?? 0 }}</td>
                            <td>{{ $item->vt_female_rural ?? 0 }}</td>
                            <td>{{ $item->vt_female_urban ?? 0 }}</td>
                            <td>{{ $item->vt_others_rural ?? 0 }}</td>
                            <td>{{ $item->vt_others_urban ?? 0 }}</td>
                            <td>{{ $item->vt_total_rural ?? 0 }}</td>
                            <td>{{ $item->vt_total_urban ?? 0 }}</td>
                            <td>{{ intval($item->vt_total_rural ?? 0) + intval($item->vt_total_urban ?? 0) }}</td>
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

                @if ($master_data->mefMfsDetailsTable5->count())
                    @foreach ($master_data->mefMfsDetailsTable5 as $item)
                        <tr>
                            <td>{{ $item->mefMfsLabel->name ?? 0 }}</td>
                            <td>{{ $item->male_rural ?? 0 }}</td>
                            <td>{{ $item->male_urban ?? 0 }}</td>
                            <td>{{ $item->female_rural ?? 0 }}</td>
                            <td>{{ $item->female_urban ?? 0 }}</td>
                            <td>{{ $item->others_rural ?? 0 }}</td>
                            <td>{{ $item->others_urban ?? 0 }}</td>
                            <td>{{ $item->total_rural ?? 0 }}</td>
                            <td>{{ $item->total_urban ?? 0 }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
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
                <li class="list-group-item text-center font-weight-bold">6. Financial Literacy Programmes (During the
                    quarter)</li>
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
                @if ($master_data->mefMfsDetailsTable6->count())
                    <tr>
                        <td>{{ $master_data->mefMfsDetailsTable6->nflpo_dhaka }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->nflpo_other_regions }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->nflpo_total }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->np_male }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->np_female }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->np_others }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable6->np_total }}</td>
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
                <li class="list-group-item text-center font-weight-bold">7. Complaints Query (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Complaints Received</th>
                    <th class="text-center">Complaints Resolved</th>
                    <th class="text-center">Received/Resolved</th>
                </tr>
                @if ($master_data->mefMfsDetailsTable8)
                    <tr>
                        <td>{{ $master_data->mefMfsDetailsTable8->complaints_received ?? null }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable8->complaints_resolved ?? null }}</td>
                        <td>{{ $master_data->mefMfsDetailsTable8->received_resolved ?? null }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>