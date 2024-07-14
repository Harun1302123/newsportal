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
                    <th rowspan="2">Divison</th>
                    <th rowspan="2">District</th>
                    <th class="text-center" colspan="5">Number of BO Accounts</th>
                </tr>
                <tr>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Institutional</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->MefCmisDetailsTable1->count())
                    @php
                        $total_male = 0;
                        $total_female = 0;
                        $total_others = 0;
                        $total_institutional = 0;
                        $total_total = 0;
                    @endphp
                    @foreach ($master_data->MefCmisDetailsTable1->sortBy('division_id')->all() as $item)
                        @php
                            $total_male += $item->nbo_accounts_male ?? 0;
                            $total_female += $item->nbo_accounts_female ?? 0;
                            $total_others += $item->nbo_accounts_others ?? 0;
                            $total_institutional += $item->nbo_accounts_institutional ?? 0;
                            $total_total += $item->nbo_total ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $item->division->area_nm ?? null }}</td>
                            <td>{{ $item->district->area_nm ?? null }}</td>
                            <td>{{ $item->nbo_accounts_male }}</td>
                            <td>{{ $item->nbo_accounts_female }}</td>
                            <td> {{ $item->nbo_accounts_others }} </td>
                            <td> {{ $item->nbo_accounts_institutional }} </td>
                            <td>{{ $item->nbo_total }}</td>
                        </tr>
                    @endforeach
                @endif

                <tr>
                    <td class="text-center" colspan="2">Total</td>
                    <td>{{ $total_male }}</td>
                    <td>{{ $total_female }}</td>
                    <td>{{ $total_others }}</td>
                    <td>{{ $total_institutional }}</td>
                    <td>{{ $total_total }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2. Automation Related Information
                </li>
            </ul>
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="20"> </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="5">Number of BO Accounts Using Mobile App</td>
                </tr>
                <tr>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Institutional</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefCmisDetailsTable2)
                    <tr>
                        <td>{{ $master_data->mefCmisDetailsTable2->number_of_boauma_male ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable2->number_of_boauma_female ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable2->number_of_boauma_others ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable2->number_of_boauma_institutional ?? null }}
                        </td>
                        <td>{{ $master_data->mefCmisDetailsTable2->total ?? null }}</td>
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
                <li class="list-group-item text-center font-weight-bold">3. CMI Related Information</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="16">During July-September 2023</td>
                </tr>
                <tr>
                    <th>Type of CMI</th>
                    <td>Number of CMIs</td>
                    <td>Number of Branch</td>
                    <td>Number of Online Branch</td>
                </tr>
                @if ($master_data->mefCmisDetailsTable3->count())
                    @php
                        $total_number_of_cmis = 0;
                        $total_number_of_branch = 0;
                        $total_number_of_online_branch = 0;
                    @endphp
                    @foreach ($master_data->mefCmisDetailsTable3 as $item)
                        @php
                            $total_number_of_cmis += $item->number_of_cmis ?? 0;
                            $total_number_of_branch += $item->number_of_branch ?? 0;
                            $total_number_of_online_branch += $item->number_of_online_branch ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $item->mefCmisLabel->name ?? null }}</td>
                            <td>{{ $item->number_of_cmis ?? null }}</td>
                            <td>{{ $item->number_of_branch ?? null }}</td>
                            <td>{{ $item->number_of_online_branch ?? null }}</td>
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
                <li class="list-group-item text-center font-weight-bold">4. Financial Literacy Programmes
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
                @if ($master_data->mefCmisDetailsTable4)
                    <tr>
                        <td>{{ $master_data->mefCmisDetailsTable4->number_of_flp_organize_dhaka ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->number_of_flp_organize_other_region ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->nflpo_total ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->number_of_participation_male ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->number_of_participation_female ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->number_of_participation_others ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable4->nop_total ?? null }}</td>
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
                <li class="list-group-item text-center font-weight-bold">5. Complaints Query (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Complaints Received</th>
                    <th class="text-center">Complaints Resolved</th>
                    <th class="text-center">Received/Resolved</th>
                </tr>
                @if ($master_data->mefCmisDetailsTable8)
                    <tr>
                        <td>{{ $master_data->mefCmisDetailsTable8->complaints_received ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable8->complaints_resolved ?? null }}</td>
                        <td>{{ $master_data->mefCmisDetailsTable8->received_resolved ?? null }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>