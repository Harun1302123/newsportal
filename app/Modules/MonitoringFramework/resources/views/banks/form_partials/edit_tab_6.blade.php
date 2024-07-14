<div id="tab_6" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">3.1 Agent and Outlet Information
            </li>
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
            @if ($master_data->mefBankDetailsTable3_1->count())
                @foreach($master_data->mefBankDetailsTable3_1 as $key => $item)
                    <tr>
                        <th style="min-width: 200px">{{ $item->mefBankLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_3_1[]"
                               value="{{  $item->mefBankLabel->id ?? null }}">
                        <input type="hidden" name="mef_bank_details_table_3_1_id[]" value="{{ $item->id ?? null }}">

                        <td>{!! Form::number('male_rural_3_1[]', $item->male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_3_1[]', $item->male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_3_1[]', $item->female_rural ?? null, [
                                            'class' => 'form-control input-md custom-input',
                                        ]) !!}</td>
                        <td>{!! Form::number('female_urban_3_1[]', $item->female_urban ?? null, [
                                            'class' => 'form-control input-md custom-input',
                                        ]) !!}</td>
                        <td>{!! Form::number('others_rural_3_1[]', $item->others_rural ?? null, [
                                            'class' => 'form-control input-md custom-input',
                                        ]) !!}</td>
                        <td>{!! Form::number('others_urban_3_1[]', $item->others_urban ?? null, [
                                            'class' => 'form-control input-md custom-input',
                                        ]) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <br>
    @include('MonitoringFramework::banks.form_partials.edit_tab_7')
    <br>
    @include('MonitoringFramework::banks.form_partials.edit_tab_8')
</div>
