<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1. Account Related Information</li>
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
                @foreach($mef_mfs_details_table_1 as $arf_label)
                    <tr>
                        <th>{{ $arf_label->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table1_label_id[]" value="{{ $arf_label->id??null }}">

                            {!! Form::number('male_rural[]', old('male_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('male_urban[]', old('male_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_rural[]', old('female_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_urban[]', old('female_urban'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_rural[]', old('others_rural'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_urban[]', old('others_urban'), ['class' => 'form-control input-md custom-input']) !!}

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
