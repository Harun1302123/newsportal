<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">1. Account Related Information</h6>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.1 Number of Account</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="19"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>

                @if ($master_data->mefNbfisDetailsTable1_1->count())
                    @foreach ($master_data->mefNbfisDetailsTable1_1 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->joint_rural ?? null }}</td>
                            <td>{{ $item->joint_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->enterprise_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.2 Outstanding Amount/Balance</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="19"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable1_2->count())
                    @foreach ($master_data->mefNbfisDetailsTable1_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->joint_rural ?? null }}</td>
                            <td>{{ $item->joint_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->enterprise_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.3 Number of Loan Disbursement during the quarter</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="19"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>

                @if ($master_data->mefNbfisDetailsTable1_1->count())
                    @foreach ($master_data->mefNbfisDetailsTable1_1 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->joint_rural ?? null }}</td>
                            <td>{{ $item->joint_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->enterprise_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.4 Volume of Loan Disbursement during the quarter</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="19"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>

                @if ($master_data->mefNbfisDetailsTable1_1->count())
                    @foreach ($master_data->mefNbfisDetailsTable1_1 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->joint_rural ?? null }}</td>
                            <td>{{ $item->joint_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->enterprise_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.5 Age Wise Account (Total
                    Individual Accounts)</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <tr>
                    <th rowspan="2">Age group</th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable1_3->count())
                    @foreach ($master_data->mefNbfisDetailsTable1_3 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">2. Borrower Information</h6>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2.1 Number of Borrower</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <th colspan="15" class="text-center">Enterprise</th>
                <tr>
                    <td class="text-center" colspan="2">Large Loan</td>
                    <td class="text-center" colspan="2">Cottage</td>
                    <td class="text-center" colspan="2">Micro</td>
                    <td class="text-center" colspan="2">Small</td>
                    <td class="text-center" colspan="2">Medium</td>
                    <td class="text-center" colspan="2">Others</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
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
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable2_1_1)
                    <tr>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->large_loan_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->large_loan_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->cottage_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->cottage_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->micro_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->micro_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->small_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->small_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->medium_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->medium_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->other_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_1_1->other_urban }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_1_1->total_rural }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_1_1->total_urban }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_1_1->total_total }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <th colspan="15" class="text-center">Individual</th>
                <tr>
                    <th rowspan="2">Age group</th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable2_1_2->count())
                    @foreach ($master_data->mefNbfisDetailsTable2_1_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif


            </table>
        </div>

        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2.2 Outstanding Balance</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <th colspan="15" class="text-center">Enterprise</th>
                <tr>
                    <td class="text-center" colspan="2">Large Loan</td>
                    <td class="text-center" colspan="2">Cottage</td>
                    <td class="text-center" colspan="2">Micro</td>
                    <td class="text-center" colspan="2">Small</td>
                    <td class="text-center" colspan="2">Medium</td>
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
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable2_2_1)
                    <tr>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->large_loan_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->large_loan_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->cottage_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->cottage_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->micro_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->micro_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->small_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->small_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->medium_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->medium_urban }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->other_rural }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable2_2_1->other_urban }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_2_1->total_rural }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_2_1->total_urban }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable2_2_1->total_total }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <th colspan="15" class="text-center">Individual</th>
                <tr>
                    <th rowspan="2">Age group</th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center text-bold" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Rural</td>
                    <td class="text-bold">Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable2_2_2->count())
                    @foreach ($master_data->mefNbfisDetailsTable2_2_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->others_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_rural ?? null }}</td>
                            <td class="text-bold">{{ $item->total_urban ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">3. Loan Classification</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="37"> </td>
                </tr>
                <tr>
                    <th rowspan="3">Loan/Investment Type</th>
                    <td class="text-center" colspan="12">Unclassified</td>
                    <td class="text-center" colspan="18">Classified</td>
                    <td class="text-center text-bold"rowspan="2" colspan="6">Total</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="6">Standard</td>
                    <td class="text-center" colspan="6">SMA</td>
                    <td class="text-center" colspan="6">SS</td>
                    <td class="text-center" colspan="6">DF</td>
                    <td class="text-center" colspan="6">B/L</td>
                </tr>
                <tr>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td class="text-bold">Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td class="text-bold">Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td class="text-bold">Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td class="text-bold">Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td class="text-bold">Total</td>
                    <td class="text-bold">Male</td>
                    <td class="text-bold">Female</td>
                    <td class="text-bold">Others</td>
                    <td class="text-bold">Joint Account</td>
                    <td class="text-bold">Enterprise</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable3->count())
                    @foreach ($master_data->mefNbfisDetailsTable3 as $key => $item)
                        <tr>
                            <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                            <td>{{ $item->u_standard_male ?? null }}</td>
                            <td>{{ $item->u_standard_female ?? null }}</td>
                            <td>{{ $item->u_standard_others ?? null }}</td>
                            <td>{{ $item->u_standard_joint ?? null }}</td>
                            <td>{{ $item->u_standard_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->u_standard_total ?? null }}</td>
                            <td>{{ $item->u_sma_male ?? null }}</td>
                            <td>{{ $item->u_sma_female ?? null }}</td>
                            <td>{{ $item->u_sma_others ?? null }}</td>
                            <td>{{ $item->u_sma_joint ?? null }}</td>
                            <td>{{ $item->u_sma_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->u_sma_total ?? null }}</td>
                            <td>{{ $item->c_ss_male ?? null }}</td>
                            <td>{{ $item->c_ss_female ?? null }}</td>
                            <td>{{ $item->c_ss_others ?? null }}</td>
                            <td>{{ $item->c_ss_joint ?? null }}</td>
                            <td>{{ $item->c_ss_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->c_ss_total ?? null }}</td>
                            <td>{{ $item->c_df_male ?? null }}</td>
                            <td>{{ $item->c_df_female ?? null }}</td>
                            <td>{{ $item->c_df_others ?? null }}</td>
                            <td>{{ $item->c_df_joint ?? null }}</td>
                            <td>{{ $item->c_df_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->c_df_total ?? null }}</td>
                            <td>{{ $item->c_bl_male ?? null }}</td>
                            <td>{{ $item->c_bl_female ?? null }}</td>
                            <td>{{ $item->c_bl_others ?? null }}</td>
                            <td>{{ $item->c_bl_joint ?? null }}</td>
                            <td>{{ $item->c_bl_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->c_bl_total ?? null }}</td>
                            <td class="text-bold">{{ $item->total_male ?? null }}</td>
                            <td class="text-bold">{{ $item->total_female ?? null }}</td>
                            <td class="text-bold">{{ $item->total_others ?? null }}</td>
                            <td class="text-bold">{{ $item->total_joint ?? null }}</td>
                            <td class="text-bold">{{ $item->total_enterprise ?? null }}</td>
                            <td class="text-bold">{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">4. DFS Related Information</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-center" colspan="3">Number of Accounts Using Internet/App Based
                    </td>
                    <td class="text-center" colspan="3">Credit Card Users</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable4)
                    <tr>
                        <td>{{ $master_data->mefNbfisDetailsTable4->nauib_rural ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable4->nauib_urban ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable4->nauib_total ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable4->ccu_rural ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable4->ccu_urban ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable4->ccu_total ?? null }}</td>

                    </tr>
                @endif
            </table>
        </div>

    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">5. Access Point Related Information</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-center" colspan="3">Number of Branches</td>
                    <td class="text-center" colspan="3"> Number of Online Branches</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable5)
                    <tr>
                        <td>{{ $master_data->mefNbfisDetailsTable5->nb_rural ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable5->nb_urban ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable5->nb_total ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable5->nob_rural ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable5->nob_urban ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable5->nob_total ?? null }}</td>
                    </tr>
                @endif

            </table>
        </div>

    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">6. Financial Literacy Programmes (During the quarter)</h6>
        </div>
        <div class="table-responsive">

            <table class="table table-bordered">
                <tr>
                    <td class="text-center" colspan="3">Number of FL Program Organized</td>
                    <td class="text-center" colspan="4">Number of Participants</td>
                </tr>
                <tr>
                    <td>Dhaka</td>
                    <td>Other Regions</td>
                    <td class="text-bold">Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td class="text-bold">Total</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable6)
                    <tr>
                        <td>{{ $master_data->mefNbfisDetailsTable6->nflpo_dhaka ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable6->nflpo_others_region ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable6->nflpo_total ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable6->np_male ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable6->np_female ?? null }}</td>
                        <td>{{ $master_data->mefNbfisDetailsTable6->np_others ?? null }}</td>
                        <td class="text-bold">{{ $master_data->mefNbfisDetailsTable6->np_total ?? null }}</td>

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
                <li class="list-group-item text-center">7. Complaints Query (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-center">Complaints Received</td>
                    <td class="text-center">Complaints Resolved</td>
                    <td class="text-center">Received/Resolved</td>
                </tr>
                @if ($master_data->mefNbfisDetailsTable8)
                <tr>
                    <td>{{ $master_data->mefNbfisDetailsTable8->complaints_received ?? null }}</td>
                    <td>{{ $master_data->mefNbfisDetailsTable8->complaints_resolved ?? null }}</td>
                    <td>{{ $master_data->mefNbfisDetailsTable8->received_resolved ?? null }}</td>
                </tr>
            @endif
            </table>
        </div>
    </div>
</div>
