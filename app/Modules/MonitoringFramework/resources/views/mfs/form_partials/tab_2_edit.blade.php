<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2. Transaction Information (Number of Transaction)</li>
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
                @if ($data->mefMfsDetailsTable2->count())
                    @foreach($data->mefMfsDetailsTable2->sortBy('id')->all() as $item)
                        <tr>
                            <th>{{ $item->mefMfsLabel->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table2_label_id[]" value="{{  $item->mefMfsLabel->id ?? null }}">

                            {!! Form::number('male_rural2[]',$item->male_rural ?? old('male_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                            <td>
                                {!! Form::number('male_urban2[]',$item->male_urban ?? old('male_urban2'), ['class' => 'form-control input-md custom-input']) !!}
                            </td>
                            <td>
                                {!! Form::number('female_rural2[]',$item->female_rural ?? old('female_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                            </td>
                            <td>
                                {!! Form::number('female_urban2[]',$item->female_urban ?? old('female_urban2'), ['class' => 'form-control input-md custom-input']) !!}
                            </td>
                            <td>
                                {!! Form::number('others_rural2[]',$item->others_rural ?? old('others_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                            </td>
                            <td>
                                {!! Form::number('others_urban2[]',$item->others_urban ?? old('others_urban2'), ['class' => 'form-control input-md custom-input']) !!}
                            </td>
                    </tr>
                @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
