<div id="tab_14" class=" tab-pane ">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                8. QR Code Transaction Information
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th class="text-center" colspan="2">QR Code Transaction (Other than Bangla QR)</th>
                    <th class="text-center" colspan="2">Bangla QR Transaction</th>
                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                </tr>
            </thead>
            @if ($master_data->mefBankDetailsTable8->count())
                @foreach($master_data->mefBankDetailsTable8 as $key => $item)
                    <tr>
                        <input type="hidden" name="mef_bank_details_table_8_id[]" value="{{ $item->id ?? null }}">
                        <th style="min-width: 200px">{{ $item->mefBankLabel->name ?? null}}</th>
                        <input type="hidden" name="mef_bank_label_id_8[]" value="{{ $item->mefBankLabel->id ?? null }}">
                        <td>{!! Form::number('qrct_rural_8[]', $item->qrct_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('qrct_urban_8[]', $item->qrct_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bqrt_rural_8[]', $item->bqrt_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bqrt_urban_8[]', $item->bqrt_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
