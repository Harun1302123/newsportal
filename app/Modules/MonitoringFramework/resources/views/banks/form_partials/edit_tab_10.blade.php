<div id="tab_10" class="tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">4.2 Transaction Information</li>
        </ul>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="3"></th>
                    <th class="text-center" colspan="6">Deposit Balance  </th>
                    <th class="text-center" colspan="6">Subsidy Disbursement (During the quarter)</th>
                </tr>
                <tr>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
                    <th class="text-center" colspan="2">Others</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
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
                </tr>
            </thead>
            @if ($master_data->mefBankDetailsTable4_2->count())
                @foreach($master_data->mefBankDetailsTable4_2 as $key => $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->mefBankLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_4_2[]" value="{{ $item->mefBankLabel->id ?? null }}">
                        <input type="hidden" name="mef_bank_details_table_4_2_id[]" value="{{ $item->id ?? null }}">

                        <td>{!! Form::number('db_male_rural_4_2[]',$item->db_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('db_male_urban_4_2[]', $item->db_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('db_female_rural_4_2[]', $item->db_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('db_female_urban_4_2[]', $item->db_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('db_others_rural_4_2[]', $item->db_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('db_others_urban_4_2[]', $item->db_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>

                        <td>{!! Form::number('sd_male_rural_4_2[]', $item->sd_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('sd_male_urban_4_2[]', $item->sd_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('sd_female_rural_4_2[]', $item->sd_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('sd_female_urban_4_2[]', $item->sd_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('sd_others_rural_4_2[]', $item->sd_others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('sd_others_urban_4_2[]', $item->sd_others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>

                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
