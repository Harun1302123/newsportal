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
                @foreach($mef_mfs_details_table_2 as $table2_label)

                    <tr>
                        <th>{{ $table2_label->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table2_label_id[]" value="{{ $table2_label->id??null }}">

                            {!! Form::number('male_rural2[]', old('male_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('male_urban2[]', old('male_urban2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_rural2[]', old('female_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_urban2[]', old('female_urban2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_rural2[]', old('others_rural2'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_urban2[]', old('others_urban2'), ['class' => 'form-control input-md custom-input']) !!}

                        </td>
                    </tr>
                @endforeach

            </table>

        </div>
    </div>
</div>
