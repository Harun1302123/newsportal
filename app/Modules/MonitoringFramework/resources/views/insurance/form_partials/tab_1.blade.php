<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1. Number of Insurance Policy
                </li>
              </ul>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Divison</th>
                    <th rowspan="2">District</th>
                    <th class="text-center" colspan="3">Total Life Insurance Policy</th>
                    <th class="text-center" colspan="3">Micro Insurance Policy</th>
                    <th class="text-center" colspan="3">Health Policy</th>
                    <th class="text-center" rowspan="2">Agricultural Policy (total number)</th>
                    <th class="text-center" rowspan="2">Non-Life Policy (total number)</th>
                </tr>
                <tr>
                    <th>Male</th>
                    <th>Femate</th>
                    <th>Others</th>
                    <th>Male</th>
                    <th>Femate</th>
                    <th>Others</th>
                    <th>Male</th>
                    <th>Femate</th>
                    <th>Others</th>
                </tr>
            </thead>

                @if (count($divisions->toArray()))
                    @foreach ($divisions as $division)
                        @if (count(getDivisionWiseDistricts($division->area_id)->toArray()))
                        @php
                            $districts = getDivisionWiseDistricts($division->area_id); // need to optimize
                            $totalData = count($districts) ?? 0;
                        @endphp
                        @foreach ($districts as $key => $district)
                        <tr>
                            @if ($key < 1)
                            <th rowspan="{{ $totalData }}" >{{ $division->area_nm??null }}</th>
                            @endif
                            <th>{{ $district->area_nm??null }}</th>
                            <input type="hidden" name="district_id[]" value="{{ $district->area_id??null }}">
                            <input type="hidden" name="division_id[]" value="{{ $division->area_id??null }}">
                            <td>{!! Form::number('tlip_male[]', old('tlip_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('tlip_female[]', old('tlip_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('tlip_others[]', old('tlip_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_male[]', old('mip_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_female[]', old('mip_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_others[]', old('mip_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_male[]', old('hp_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_female[]', old('hp_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_others[]', old('hp_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ap_total_number[]', old('ap_total_number[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nfp_total_number[]', old('nfp_total_number[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                @endif


{{--
                <tr>
                    <td class="text-center" colspan="2">Totals</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr> --}}
            </table>
        </div>
    </div>
</div>
