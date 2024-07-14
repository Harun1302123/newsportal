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
                @if( $mef_mfs_details_table_5->count() < 2)
                    <tr>
                        <th>{{ $mef_mfs_details_table_5[0]->name }}</th>
                        <td>
                            <input type="hidden" name="mef_mfs_table5_label_id" value="25">
                            {!! Form::number('male_rural5', old('male_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('male_urban5', old('male_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                        <td>
                            {!! Form::number('female_rural5', old('female_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('female_urban5', old('female_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                        <td>
                            {!! Form::number('others_rural5', old('others_rural5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('others_urban5', old('others_urban5'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                    </tr>

                @endif

{{--                @foreach($agent_label as $agent_label)--}}
{{--                    <tr>--}}
{{--                        <th>{{ $agent_label->name }}</th>--}}
{{--                        <td>--}}
{{--                            <input type="hidden" name="mef_mfs_table4_label_id" value="{{ $mef_mfs_details_table_4[0]->id??null }}">--}}
{{--                            {!! Form::number('nt_male_rural', old('nt_male_rural'), ['class' => 'form-control input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('nt_male_urban', old('nt_male_urban'), ['class' => 'form-control input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('nt_female_rural', old('nt_female_rural'), ['class' => 'form-control input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('nt_female_urban', old('nt_female_urban'), ['class' => 'form-control input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('nt_others_rural', old('nt_others_rural'), ['class' => 'form-control input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('nt_others_urban', old('nt_others_urban'), ['class' => 'form-control input-md custom-input']) !!}--}}

{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_male_rural', old('vt_male_rural'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_male_urban', old('vt_male_urban'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_female_rural', old('vt_female_rural'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_female_urban', old('vt_female_urban'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_others_rural', old('vt_others_rural'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            {!! Form::number('vt_others_urban', old('vt_others_urban'), ['class' => 'form-covtrol input-md custom-input']) !!}--}}

{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
            </table>
        </div>
    </div>
</div>
