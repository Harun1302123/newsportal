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
            @if ($master_data->mefNbfisDetailsTable1_1->count())
                @foreach($master_data->mefNbfisDetailsTable1_1 as $key => $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->mefNbfisLabel->name ?? null}}</th>
                        <input type="hidden" name="mef_nbfis_label_id_1_1[]" value="{{ $item->mef_nbfis_label_id ?? null }}">
                        <input type="hidden" name="mef_nbfis_details_table_1_1_id[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_1_1[]', $item->male_rural ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_1[]', $item->male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_1[]', $item->female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_1[]', $item->female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_1[]', $item->others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_1[]', $item->others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_rural_1_1[]', $item->joint_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('joint_urban_1_1[]', $item->joint_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_rural_1_1[]',$item->enterprise_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('enterprise_urban_1_1[]', $item->enterprise_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <br>
    @include('MonitoringFramework::nbfis.form_partials.edit_tab_2')
    <br>
    @include('MonitoringFramework::nbfis.form_partials.edit_tab_11')
    <br>
    @include('MonitoringFramework::nbfis.form_partials.edit_tab_12')
    <br>
    @include('MonitoringFramework::nbfis.form_partials.edit_tab_3')
</div>
