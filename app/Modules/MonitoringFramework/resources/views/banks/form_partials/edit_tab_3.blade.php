<div id="tab_1" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">1.5 Age Wise Account (Total
                Individual Accuonts)</li>
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
            @if ($master_data->mefBankDetailsTable1_3->count())
                @foreach($master_data->mefBankDetailsTable1_3 as $key => $item)
                    <tr>
                        <th>{{ $item->mefBankLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_bank_label_id_1_3[]" value="{{ $item->mefBankLabel->id ?? null }}">
                        <input type="hidden" name="mef_bank_details_table_1_3_id[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_1_3[]', $item->male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_1_3[]', $item->male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_1_3[]', $item->female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_1_3[]', $item->female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_1_3[]', $item->others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_1_3[]', $item->others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
