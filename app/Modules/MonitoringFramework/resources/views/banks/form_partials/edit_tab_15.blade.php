<div id="tab_15" class=" tab-pane ">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                9. Foreign Remittance
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="3"></th>
                    <th class="text-center" colspan="6">Number of Transaction</th>
                    <th class="text-center" colspan="6">Amount of Transaction (in USD)</th>
                </tr>
                <tr>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
                    <th class="text-center" colspan="2">Institutional</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
                    <th class="text-center" colspan="2">Institutional</th>
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
            @if ($master_data->mefBankDetailsTable9->count())
                @foreach($master_data->mefBankDetailsTable9 as $key => $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->mefBankLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_details_table_9_id[]" value="{{ $item->id ?? null }}">
                        <input type="hidden" name="mef_bank_label_id_9[]" value="{{ $item->mefBankLabel->id ?? null}}">
                        <td>{!! Form::number('nt_male_rural[]', $item->nt_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_male_urban[]', $item->nt_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_female_rural[]', $item->nt_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_female_urban[]', $item->nt_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_institutional_rural[]', $item->nt_institutional_rural ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nt_institutional_urban[]', $item->nt_institutional_urban ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('at_male_rural[]', $item->at_male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_male_urban[]', $item->at_male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_female_rural[]', $item->at_female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_female_urban[]', $item->at_female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_institutional_rural[]', $item->at_institutional_rural ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('at_institutional_urban[]', $item->at_institutional_urban ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
