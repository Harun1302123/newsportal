<div id="tab_3" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">3. Transaction Information (Volume of Transaction)</li>
            </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-right" colspan="16">During the Quarter</th>
                    </tr>
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
                @foreach($mef_mfs_details_table_3 as $table3_label)

                    <tr>
                        <th>{{ $table3_label->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table3_label_id[]" value="{{ $table3_label->id??null }}">

                            {!! Form::number('male_rural3[]', old('male_rural3'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('male_urban3[]', old('male_urban3'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_rural3[]', old('female_rural3'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_urban3[]', old('female_urban3'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_rural3[]', old('others_rural3'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_urban3[]', old('others_urban3'), ['class' => 'form-control input-md custom-input']) !!}

                        </td>
                    </tr>
                @endforeach

            </table>

        </div>
    </div>
</div>
