<div id="tab_2" class="tab-pane ">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">1.2 Outstanding Amount/Balance
            </li>
        </ul>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
                    <th class="text-center" colspan="2">Others</th>
                    <th class="text-center" colspan="2">Joint Account</th>
                    <th class="text-center" colspan="2">Enterprise/Farm</th>
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
                </tr>
            </thead>
            @if (count($mef_nbfis_details_table_1_2->toArray()))
                @foreach ($mef_nbfis_details_table_1_2 as $item)
                    <tr>
                        <th>{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_1_2[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_1_2[]', old('male_rural_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_2[]', old('male_urban_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_2[]', old('female_rural_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_2[]', old('female_urban_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_2[]', old('others_rural_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_2[]', old('others_urban_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_rural_1_2[]', old('joint_rural_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_urban_1_2[]', old('joint_urban_1_2'), ['class' => 'form-control input-md custom-input']) !!}</td> 
                        <td>{!! Form::number('enterprise_rural_1_2[]', old('enterprise_rural_1_2'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('enterprise_urban_1_2[]', old('enterprise_urban_1_2'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
