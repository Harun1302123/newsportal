<div id="tab_5" class="tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">2.2 Outstanding Balance</li>
        </ul>

        <table class="table table-bordered">
            <thead>
                <th colspan="15" class="text-center">Enterprise</th>
                <tr>
                    <th class="text-center" colspan="2">Large Loan</th>
                    <th class="text-center" colspan="2">Cottage</th>
                    <th class="text-center" colspan="2">Micro</th>
                    <th class="text-center" colspan="2">Small</th>
                    <th class="text-center" colspan="2">Medium</th>
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
            <tr>
                <th class="d-none">{{ $item->name ?? null }}</th>
                <td>{!! Form::number('large_loan_rural_2_2_1', old('large_loan_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('large_loan_urban_2_2_1', old('large_loan_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('cottage_rural_2_2_1', old('cottage_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('cottage_urban_2_2_1', old('cottage_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('micro_rural_2_2_1', old('micro_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('micro_urban_2_2_1', old('micro_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('small_rural_2_2_1', old('small_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('small_urban_2_2_1', old('small_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('medium_rural_2_2_1', old('medium_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('medium_urban_2_2_1', old('medium_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('other_rural_2_2_1', old('other_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('other_urban_2_2_1', old('other_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
            </tr>
        </table>
    </div>

    <div class="table-responsive pt-4">
        <table class="table table-bordered">
            <thead>
                <th colspan="15" class="text-center">Individual</th>
                <tr>
                    <th rowspan="2" style="min-width: 110px;">Age group</th>
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
                </tr>
            </thead>
            @if (count($mef_nbfis_details_table_2_2_2->toArray()))
                @foreach ($mef_nbfis_details_table_2_2_2 as $item)
                    <tr>
                        <th>{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_2_2_2[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_2_2_2[]', old('male_rural_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_2_2_2[]', old('male_urban_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_2_2_2[]', old('female_rural_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_2_2_2[]', old('female_urban_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_2_2_2[]', old('others_rural_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_2_2_2[]', old('others_urban_2_2_2[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
