<div id="tab_5" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">5. Agent Information</li>
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
                @if ($data->mefMfsDetailsTable5->count())
                    @php
                        $item = $data->mefMfsDetailsTable5[0];
                    @endphp
                    <tr>
                        <th>{{ $item->mefMfsLabel->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table5_label_id" value="{{ $item->mefMfsLabel->id??null }}">
                            {!! Form::number('male_rural5', $item->male_rural ?? old('male_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('male_urban5', $item->male_urban ?? old('male_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                        <td>
                            {!! Form::number('female_rural5', $item->female_rural ?? old('female_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_urban5', $item->female_urban ?? old('female_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                        <td>
                            {!! Form::number('others_rural5', $item->others_rural ?? old('others_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_urban5', $item->others_urban ?? old('others_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                    </tr>

                @endif

            </table>

        </div>
    </div>
</div>
