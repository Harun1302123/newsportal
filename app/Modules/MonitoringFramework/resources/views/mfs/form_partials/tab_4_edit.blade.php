<div id="tab_4" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">4. Foreign Remittance</li>
            </ul>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-right" colspan="25">During the quarter</th>
                    </tr>
                    <tr>
                        <th rowspan="3"></th>
                        <th class="text-center" colspan="6">Number of Transaction</th>
                        <th class="text-center" colspan="6">Volume of Transaction (Amount in USD)</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">Male</th>
                        <th class="text-center" colspan="2">female</th>
                        <th class="text-center" colspan="2">Others</th>
    
                        <th class="text-center" colspan="2">Male</th>
                        <th class="text-center" colspan="2">female</th>
                        <th class="text-center" colspan="2">Others</th>
                    </tr>
                    <tr>
                        <!-- NT -->
                        <th>Rural</th>
                        <th>Urban</th>
    
                        <th>Rural</th>
                        <th>Urban</th>
    
                        <th>Rural</th>
                        <th>Urban</th>
    
                        <!-- NT -->
    
                        <!-- VT -->
                        <th>Rural</th>
                        <th>Urban</th>
    
                        <th>Rural</th>
                        <th>Urban</th>
    
                        <th>Rural</th>
                        <th>Urban</th>
                        <!-- VT -->
                    </tr>
                </thead>
                @if ($data->mefMfsDetailsTable4->count())
                    @php
                        $item = $data->mefMfsDetailsTable4[0];
                    @endphp
                        <tr>
                            <th>{{ $item->mefMfsLabel->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table4_label_id" value="{{ $item->mefMfsLabel->id??null }}">
                            {!! Form::number('nt_male_rural', $item->nt_male_rural ?? old('nt_male_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nt_male_urban', $item->nt_male_urban ?? old('nt_male_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nt_female_rural', $item->nt_female_rural ?? old('nt_female_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nt_female_urban', $item->nt_female_urban ?? old('nt_female_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nt_others_rural', $item->nt_others_rural ?? old('nt_others_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nt_others_urban', $item->nt_others_urban ?? old('nt_others_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_male_rural', $item->vt_male_rural ?? old('vt_male_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_male_urban', $item->vt_male_urban ?? old('vt_male_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_female_rural', $item->vt_female_rural ?? old('vt_female_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_female_urban', $item->vt_female_urban ?? old('vt_female_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_others_rural', $item->vt_others_rural ?? old('vt_others_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('vt_others_urban', $item->vt_others_urban ?? old('vt_others_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                    </tr>
                @endif
            </table>

        </div>
    </div>
</div>
