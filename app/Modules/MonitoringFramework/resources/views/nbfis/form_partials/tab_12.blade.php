<div id="tab_1" class="tab-pane active">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">1.4 Volume of Loan Disbursement during the quarter</li>
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

             @if (count($mef_nbfis_details_table_1_5->toArray()))
                @foreach ($mef_nbfis_details_table_1_5 as $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_1_5[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_1_5[]', old('male_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_5[]', old('male_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_5[]', old('female_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_5[]', old('female_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_5[]', old('others_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_5[]', old('others_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_rural_1_5[]', old('joint_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_urban_1_5[]', old('joint_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_rural_1_5[]', old('enterprise_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_urban_1_5[]', old('enterprise_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
