<div id="tab_3" class="tab-pane ">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">1.5 Age Wise Account (Total
                Individual Accounts)</li>
        </ul>

        <table class="table table-bordered">
            <thead>
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
            @if (count($mef_nbfis_details_table_1_3->toArray()))
                @foreach ($mef_nbfis_details_table_1_3 as $item)
                    <tr>
                        <th>{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_1_3[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_1_3[]', old('male_rural_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_3[]', old('male_urban_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_3[]', old('female_rural_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_3[]', old('female_urban_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_3[]', old('others_rural_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_3[]', old('others_urban_1_3'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
