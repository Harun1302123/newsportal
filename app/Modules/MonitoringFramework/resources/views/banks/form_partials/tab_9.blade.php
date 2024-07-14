<div id="tab_9" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">4.1 Number of Account</li>
        </ul>

        <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2"></th>
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
            @if (count($mef_bank_details_table_4_1->toArray()))
                @foreach ($mef_bank_details_table_4_1 as $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_4_1[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_4_1[]', old('male_rural_4_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_4_1[]', old('male_urban_4_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_4_1[]', old('female_rural_4_1'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('female_urban_4_1[]', old('female_urban_4_1'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('others_rural_4_1[]', old('others_rural_4_1'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('others_urban_4_1[]', old('others_urban_4_1'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

    <br>
    @include('MonitoringFramework::banks.form_partials.tab_10')
</div>
