<div id="tab_12" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                6. DFS Related Information
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" colspan="8">Number of Accounts Using Internet Banking/AppBased Banking</td>
                    <th class="text-center" colspan="8">Debit Card Users</th>
                    <th class="text-center" colspan="6">Credit Card Users</th>
                    <th class="text-center" colspan="6">Prepaid Card Users</th>

                </tr>
                <tr>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2"> Female</th>
                    <th class="text-center" colspan="2">Others</td>
                    <th class="text-center" colspan="2">Joint Account</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2"> Female</th>
                    <th class="text-center" colspan="2">Others</th>
                    <th class="text-center" colspan="2">Joint Account</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2"> Female</th>
                    <th class="text-center" colspan="2">Others</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2"> Female</th>
                    <th class="text-center" colspan="2">Others</th>

                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                </tr>
            </thead>
            @if ($master_data->mefBankDetailsTable6)
            <tr>
                <input type="hidden" name="mef_bank_details_table_6_id" value="{{ $master_data->mefBankDetailsTable6->id ?? null }}">

                <td>{!! Form::number('nauib_male_rural_6', $master_data->mefBankDetailsTable6->nauib_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_male_urban_6', $master_data->mefBankDetailsTable6->nauib_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_female_rural_6', $master_data->mefBankDetailsTable6->nauib_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_female_urban_6', $master_data->mefBankDetailsTable6->nauib_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_others_rural_6', $master_data->mefBankDetailsTable6->nauib_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_others_urban_6', $master_data->mefBankDetailsTable6->nauib_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_joint_rural_6',  $master_data->mefBankDetailsTable6->nauib_joint_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_joint_urban_6',  $master_data->mefBankDetailsTable6->nauib_joint_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_male_rural_6', $master_data->mefBankDetailsTable6->dcu_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_male_urban_6', $master_data->mefBankDetailsTable6->dcu_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_female_rural_6', $master_data->mefBankDetailsTable6->dcu_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_female_urban_6', $master_data->mefBankDetailsTable6->dcu_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_joint_rural_6',  $master_data->mefBankDetailsTable6->dcu_joint_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_joint_urban_6',  $master_data->mefBankDetailsTable6->dcu_joint_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_others_rural_6', $master_data->mefBankDetailsTable6->dcu_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('dcu_others_urban_6', $master_data->mefBankDetailsTable6->dcu_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_male_rural_6', $master_data->mefBankDetailsTable6->ccu_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_male_urban_6', $master_data->mefBankDetailsTable6->ccu_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_female_rural_6', $master_data->mefBankDetailsTable6->ccu_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_female_urban_6', $master_data->mefBankDetailsTable6->ccu_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_others_rural_6', $master_data->mefBankDetailsTable6->ccu_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_others_urban_6', $master_data->mefBankDetailsTable6->ccu_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_male_rural_6', $master_data->mefBankDetailsTable6->pcu_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_male_urban_6',$master_data->mefBankDetailsTable6->pcu_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_female_rural_6', $master_data->mefBankDetailsTable6->pcu_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_female_urban_6', $master_data->mefBankDetailsTable6->pcu_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_others_rural_6', $master_data->mefBankDetailsTable6->pcu_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('pcu_others_urban_6', $master_data->mefBankDetailsTable6->pcu_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>

            </tr>
                @endif
        </table>
    </div>
</div>
