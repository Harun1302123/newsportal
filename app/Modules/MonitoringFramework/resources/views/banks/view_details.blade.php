
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
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>

                @if ($master_data->mefBankDetailsTable1_1->count())
                    @foreach ($master_data->mefBankDetailsTable1_1 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
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
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable1_2->count())
                    @foreach ($master_data->mefBankDetailsTable1_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
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
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable1_3->count())
                    @foreach ($master_data->mefBankDetailsTable1_3 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
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
                    <td class="text-right" colspan="16"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable1_2->count())
                    @foreach ($master_data->mefBankDetailsTable1_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1.5 Age Wise Account (Total Individual
                    Accounts)</li>
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
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable1_3->count())
                    @foreach ($master_data->mefBankDetailsTable1_3 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
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
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable2_1_1)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->large_loan_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->large_loan_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->cottage_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->cottage_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->micro_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->micro_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->small_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->small_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->medium_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->medium_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->other_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->other_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->total_rural }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->total_urban }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_1_1->total_total }}</td>
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
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable2_1_2->count())
                    @foreach ($master_data->mefBankDetailsTable2_1_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
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
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable2_2_1)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->large_loan_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->large_loan_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->cottage_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->cottage_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->micro_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->micro_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->small_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->small_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->medium_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->medium_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->other_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->other_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->total_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->total_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable2_2_1->total_total ?? null }}</td>
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
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable2_2_2->count())
                    @foreach ($master_data->mefBankDetailsTable2_2_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
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
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">3. Agent Banking Information</h6>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">3.1 Agent and Outlet Information</li>
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
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable3_1->count())
                    @foreach ($master_data->mefBankDetailsTable3_1 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>

        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">3.2 Agent Banking Accounts</li>
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
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable3_2->count())
                    @foreach ($master_data->mefBankDetailsTable3_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">3.3 Agent Banking Transaction Information</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="22"> </td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">Female</td>
                    <td class="text-center" colspan="3">Others</td>
                    <td class="text-center" colspan="3">Joint Account</td>
                    <td class="text-center" colspan="3">Enterprise/Farm</td>
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable3_3->count())
                    @foreach ($master_data->mefBankDetailsTable3_3 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->Joint_rural ?? null }}</td>
                            <td>{{ $item->Joint_urban ?? null }}</td>
                            <td>{{ $item->Joint_total ?? null }}</td>
                            <td>{{ $item->enterprise_rural ?? null }}</td>
                            <td>{{ $item->enterprise_urban ?? null }}</td>
                            <td>{{ $item->enterprise_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
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
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">4. No-Frill Accounts Information</h6>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">4.1 Number of Account</li>
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
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable4_1->count())
                    @php
                        $total_male_rural = 0;
                        $total_male_urban = 0;
                        $total_male_total = 0;
                        $total_female_rural = 0;
                        $total_female_urban = 0;
                        $total_female_total = 0;
                        $total_others_rural = 0;
                        $total_others_urban = 0;
                        $total_others_total = 0;
                        $total_total_rural = 0;
                        $total_total_urban = 0;
                        $total_total_total = 0;

                    @endphp
                    @foreach ($master_data->mefBankDetailsTable4_1 as $key => $item)
                        @php
                            $total_male_rural += $item->male_rural;
                            $total_male_urban += $item->male_urban;
                            $total_male_total += $item->male_total;
                            $total_female_rural += $item->female_rural;
                            $total_female_urban += $item->female_urban;
                            $total_female_total += $item->female_total;
                            $total_others_rural += $item->others_rural;
                            $total_others_urban += $item->others_urban;
                            $total_others_total += $item->others_total;
                            $total_total_rural += $item->total_rural;
                            $total_total_urban += $item->total_urban;
                            $total_total_total += $item->total_total;
                        @endphp
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->male_rural ?? null }}</td>
                            <td>{{ $item->male_urban ?? null }}</td>
                            <td>{{ $item->male_total ?? null }}</td>
                            <td>{{ $item->female_rural ?? null }}</td>
                            <td>{{ $item->female_urban ?? null }}</td>
                            <td>{{ $item->female_total ?? null }}</td>
                            <td>{{ $item->others_rural ?? null }}</td>
                            <td>{{ $item->others_urban ?? null }}</td>
                            <td>{{ $item->others_total ?? null }}</td>
                            <td>{{ $item->total_rural ?? null }}</td>
                            <td>{{ $item->total_urban ?? null }}</td>
                            <td>{{ $item->total_total ?? null }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        <th>{{ $total_male_rural }}</th>
                        <th>{{ $total_male_urban }}</th>
                        <th>{{ $total_male_total }}</th>
                        <th>{{ $total_female_rural }}</th>
                        <th>{{ $total_female_urban }}</th>
                        <th>{{ $total_female_total }}</th>
                        <th>{{ $total_others_rural }}</th>
                        <th>{{ $total_others_urban }}</th>
                        <th>{{ $total_others_total }}</th>
                        <th>{{ $total_total_rural }}</th>
                        <th>{{ $total_total_urban }}</th>
                        <th>{{ $total_total_total }}</th>
                    </tr>
                @endif
            </table>
        </div>
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">4.2 Transaction Information</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <th rowspan="3"></th>
                    <td class="text-center" colspan="9">Deposit Balance  </td>
                    <td class="text-center" colspan="9">Subsidy Disbursement (During the quarter)</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2">Male</td>
                    <td class="text-center" colspan="2">Female</td>
                    <td class="text-center" colspan="2">Others</td>
                    <td class="text-center" colspan="3">Total</td>
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
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable4_2->count())
                    @foreach ($master_data->mefBankDetailsTable4_2 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->db_male_rural ?? null }}</td>
                            <td>{{ $item->db_male_urban ?? null }}</td>
                            <td>{{ $item->db_female_rural ?? null }}</td>
                            <td>{{ $item->db_female_urban ?? null }}</td>
                            <td>{{ $item->db_others_rural ?? null }}</td>
                            <td>{{ $item->db_others_urban ?? null }}</td>
                            <td>{{ $item->db_total_rural ?? null }}</td>
                            <td>{{ $item->db_total_urban ?? null }}</td>
                            <td>{{ $item->db_total_total ?? null }}</td>
                            <td>{{ $item->sd_male_rural ?? null }}</td>
                            <td>{{ $item->sd_male_urban ?? null }}</td>
                            <td>{{ $item->sd_female_rural ?? null }}</td>
                            <td>{{ $item->sd_female_urban ?? null }}</td>
                            <td>{{ $item->sd_others_rural ?? null }}</td>
                            <td>{{ $item->sd_others_urban ?? null }}</td>
                            <td>{{ $item->sd_total_rural ?? null }}</td>
                            <td>{{ $item->sd_total_urban ?? null }}</td>
                            <td>{{ $item->sd_total_total ?? null }}</td>
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
            <h6 class="card-title pb-2">5. Loan Classification</h6>
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
                    <td class="text-center"rowspan="2" colspan="6">Total</td>
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
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Joint Account</td>
                    <td>Enterprise</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable5->count())
                    @foreach ($master_data->mefBankDetailsTable5 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->u_standard_male ?? null }}</td>
                            <td>{{ $item->u_standard_female ?? null }}</td>
                            <td>{{ $item->u_standard_others ?? null }}</td>
                            <td>{{ $item->u_standard_joint ?? null }}</td>
                            <td>{{ $item->u_standard_enterprise ?? null }}</td>
                            <td>{{ $item->u_standard_total ?? null }}</td>
                            <td>{{ $item->u_sma_male ?? null }}</td>
                            <td>{{ $item->u_sma_female ?? null }}</td>
                            <td>{{ $item->u_sma_others ?? null }}</td>
                            <td>{{ $item->u_sma_joint ?? null }}</td>
                            <td>{{ $item->u_sma_enterprise ?? null }}</td>
                            <td>{{ $item->u_sma_total ?? null }}</td>
                            <td>{{ $item->c_ss_male ?? null }}</td>
                            <td>{{ $item->c_ss_female ?? null }}</td>
                            <td>{{ $item->c_ss_others ?? null }}</td>
                            <td>{{ $item->c_ss_joint ?? null }}</td>
                            <td>{{ $item->c_ss_enterprise ?? null }}</td>
                            <td>{{ $item->c_ss_total ?? null }}</td>
                            <td>{{ $item->c_df_male ?? null }}</td>
                            <td>{{ $item->c_df_female ?? null }}</td>
                            <td>{{ $item->c_df_others ?? null }}</td>
                            <td>{{ $item->c_df_joint ?? null }}</td>
                            <td>{{ $item->c_df_enterprise ?? null }}</td>
                            <td>{{ $item->c_df_total ?? null }}</td>
                            <td>{{ $item->c_bl_male ?? null }}</td>
                            <td>{{ $item->c_bl_female ?? null }}</td>
                            <td>{{ $item->c_bl_others ?? null }}</td>
                            <td>{{ $item->c_bl_joint ?? null }}</td>
                            <td>{{ $item->c_bl_enterprise ?? null }}</td>
                            <td>{{ $item->c_bl_total ?? null }}</td>
                            <td>{{ $item->total_male ?? null }}</td>
                            <td>{{ $item->total_female ?? null }}</td>
                            <td>{{ $item->total_others ?? null }}</td>
                            <td>{{ $item->total_joint ?? null }}</td>
                            <td>{{ $item->total_enterprise ?? null }}</td>
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
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">6. DFS Related Information</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="28"> </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="8">Number of Accounts Using Internet Banking/App Based Banking
                    </td>
                    <td class="text-center" colspan="8">Debit Card Users</td>
                    <td class="text-center" colspan="6">Credit Card Users</td>
                    <td class="text-center" colspan="6">Prepaid Card Users</td>

                </tr>
                <tr>
                    <td class="text-center" colspan="2">Male</td>
                    <td class="text-center" colspan="2"> Female</td>
                    <td class="text-center" colspan="2">Joint Account</td>
                    <td class="text-center" colspan="2">Others</td>
                    <td class="text-center" colspan="2">Male</td>
                    <td class="text-center" colspan="2">Joint Account</td>
                    <td class="text-center" colspan="2"> Female</td>
                    <td class="text-center" colspan="2">Others</td>
                    <td class="text-center" colspan="2">Male</td>
                    <td class="text-center" colspan="2"> Female</td>
                    <td class="text-center" colspan="2">Others</td>
                    <td class="text-center" colspan="2">Male</td>
                    <td class="text-center" colspan="2"> Female</td>
                    <td class="text-center" colspan="2">Others</td>
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
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Rural</td>
                    <td>Urban</td>
                </tr>
                @if ($master_data->mefBankDetailsTable6)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_male_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_male_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_female_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_female_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_joint_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_joint_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_others_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->nauib_others_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_male_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_male_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_female_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_female_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_joint_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_joint_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_others_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->dcu_others_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_male_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_male_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_female_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_female_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_others_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->ccu_others_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_male_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_male_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_female_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_female_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_others_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable6->pcu_others_urban ?? null }}</td>
                    </tr>
                @endif
            </table>
        </div>

    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">7. Access Point Related Information</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="21"> </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">Number of Branches</td>
                    <td class="text-center" colspan="3"> Number of Online Branches</td>
                    <td class="text-center" colspan="3">Number of Sub Branches</td>
                    <td class="text-center" colspan="3">Number of ATM</td>
                    <td class="text-center" colspan="3"> Number of CDM</td>
                    <td class="text-center" colspan="3">Number of CRM</td>
                    <td class="text-center" colspan="3">Number of POS</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable7)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable7->nb_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nb_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nb_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nob_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nob_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nob_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nsb_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nsb_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->nsb_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->na_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->na_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->na_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncdm_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncdm_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncdm_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncrm_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncrm_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->ncrm_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->npos_rural ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->npos_urban ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable7->npos_total ?? null }}</td>
                    </tr>
                @endif

            </table>
        </div>

    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class=" mx-auto d-block">
            <h6 class="card-title pb-2">8. QR Code Transaction Information</h6>
        </div>
        <div class="table-responsive">

            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="7">During the quarter</td>
                </tr>
                <tr>
                    <th rowspan="2"></th>
                    <td class="text-center" colspan="3">QR Code Transaction (Other than Bangla QR)</td>
                    <td class="text-center" colspan="3">Bangla QR Transaction</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable8->count())
                    @foreach ($master_data->mefBankDetailsTable8 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->qrct_rural ?? null }}</td>
                            <td>{{ $item->qrct_urban ?? null }}</td>
                            <td>{{ $item->qrct_total ?? null }}</td>
                            <td>{{ $item->bqrt_rural ?? null }}</td>
                            <td>{{ $item->bqrt_urban ?? null }}</td>
                            <td>{{ $item->bqrt_total ?? null }}</td>
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
            <h6 class="card-title pb-2">9. Foreign Remittance</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" colspan="25">During the quarter</td>
                </tr>
                <tr>
                    <th rowspan="3"></th>
                    <td class="text-center" colspan="12">Number of Transaction</td>
                    <td class="text-center" colspan="12">Amount of Transaction (in USD)</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">female</td>
                    <td class="text-center" colspan="3">institutional</td>
                    <td class="text-center" colspan="3">Total</td>
                    <td class="text-center" colspan="3">Male</td>
                    <td class="text-center" colspan="3">female</td>
                    <td class="text-center" colspan="3">institutional</td>
                    <td class="text-center" colspan="3">Total</td>
                </tr>
                <tr>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                    <td>Rural</td>
                    <td>Urban</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable9->count())
                    @foreach ($master_data->mefBankDetailsTable9 as $key => $item)
                        <tr>
                            <th>{{ $item->mefBankLabel->name ?? null }}</th>
                            <td>{{ $item->nt_male_rural ?? null }}</td>
                            <td>{{ $item->nt_male_urban ?? null }}</td>
                            <td>{{ $item->nt_male_total ?? null }}</td>
                            <td>{{ $item->nt_female_rural ?? null }}</td>
                            <td>{{ $item->nt_female_urban ?? null }}</td>
                            <td>{{ $item->nt_female_total ?? null }}</td>
                            <td>{{ $item->nt_institutional_rural ?? null }}</td>
                            <td>{{ $item->nt_institutional_urban ?? null }}</td>
                            <td>{{ $item->nt_institutional_total ?? null }}</td>
                            <td>{{ $item->nt_total_rural ?? null }}</td>
                            <td>{{ $item->nt_total_urban ?? null }}</td>
                            <td>{{ $item->nt_total_total ?? null }}</td>
                            <td>{{ $item->at_male_rural ?? null }}</td>
                            <td>{{ $item->at_male_urban ?? null }}</td>
                            <td>{{ $item->at_male_total ?? null }}</td>
                            <td>{{ $item->at_female_rural ?? null }}</td>
                            <td>{{ $item->at_female_urban ?? null }}</td>
                            <td>{{ $item->at_female_total ?? null }}</td>
                            <td>{{ $item->at_institutional_rural ?? null }}</td>
                            <td>{{ $item->at_institutional_urban ?? null }}</td>
                            <td>{{ $item->at_institutional_total ?? null }}</td>
                            <td>{{ $item->at_total_rural ?? null }}</td>
                            <td>{{ $item->at_total_urban ?? null }}</td>
                            <td>{{ $item->at_total_total ?? null }}</td>
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
            <h6 class="card-title pb-2">10. Financial Literacy Programmes (During the quarter)</h6>
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
                    <td>Total</td>
                    <td>Male</td>
                    <td>Female</td>
                    <td>Others</td>
                    <td>Total</td>
                </tr>
                @if ($master_data->mefBankDetailsTable10)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable10->nflpo_dhaka ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->nflpo_others_region ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->nflpo_total ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->np_male ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->np_female ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->np_others ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable10->np_total ?? null }}</td>

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
                <li class="list-group-item text-center">11. Complaints Query (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                <tr>
                    <td>Complaints Received</td>
                    <td>Complaints Resolved</td>
                    <td>Received/Resolved</td>
                </tr>
                @if ($master_data->mefBankDetailsTable12)
                    <tr>
                        <td>{{ $master_data->mefBankDetailsTable12->complaints_received ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable12->complaints_resolved ?? null }}</td>
                        <td>{{ $master_data->mefBankDetailsTable12->received_resolved ?? null }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
