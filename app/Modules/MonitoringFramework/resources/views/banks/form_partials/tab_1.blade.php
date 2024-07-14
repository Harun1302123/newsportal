<div id="tab_1" class="tab-pane active">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">1.1 Number of Account</li>
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

            @if (count($mef_bank_details_table_1_1->toArray()))
                @foreach ($mef_bank_details_table_1_1 as $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_1_1[]" value="{{ $item->id ?? null }}" aria-label="mef_bank_label_id_1_1[]">
                        <td>{!! Form::number('male_rural_1_1[]', old('male_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_1[]', old('male_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_1[]', old('female_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_1[]', old('female_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_1[]', old('others_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_1[]', old('others_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_rural_1_1[]', old('joint_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_urban_1_1[]', old('joint_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_rural_1_1[]', old('enterprise_rural'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_urban_1_1[]', old('enterprise_urban'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
<br>
    @include('MonitoringFramework::banks.form_partials.tab_2')
<br>
    @include('MonitoringFramework::banks.form_partials.tab_18')
<br>
    @include('MonitoringFramework::banks.form_partials.tab_19')
<br>
    @include('MonitoringFramework::banks.form_partials.tab_3')
</div>
