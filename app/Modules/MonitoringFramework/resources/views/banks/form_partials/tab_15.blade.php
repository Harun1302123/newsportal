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
            @if (count($mef_bank_details_table_9->toArray()))
                @foreach ($mef_bank_details_table_9 as $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_9[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('nt_male_rural[]', old('nt_male_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_male_urban[]', old('nt_male_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_female_rural[]', old('nt_female_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_female_urban[]', old('nt_female_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nt_institutional_rural[]', old('nt_institutional_rural'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nt_institutional_urban[]', old('nt_institutional_urban'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('at_male_rural[]', old('at_male_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_male_urban[]', old('at_male_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_female_rural[]', old('at_female_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_female_urban[]', old('at_female_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('at_institutional_rural[]', old('at_institutional_rural'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('at_institutional_urban[]', old('at_institutional_urban'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
