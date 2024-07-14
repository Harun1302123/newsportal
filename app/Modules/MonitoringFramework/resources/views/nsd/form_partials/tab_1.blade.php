<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1. Account Related Information
                </li>
              </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="4">Number of Beneficiary of NSC</th>
                        <th class="text-center" colspan="3">Number of Accounts with BPO</th>
                        <th class="text-center" colspan="3">Number of Postal Life Insurance Policy Holders</th>
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                        <th>Joint</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                        <th>Male</th>
                        <th>Female</th>
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
                            <td>{!! Form::number('nb_nsc_male[]', old('nb_nsc_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nb_nsc_female[]', old('nb_nsc_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nb_nsc_others[]', old('nb_nsc_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nb_nsc_joint[]', old('nb_nsc_joint[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('na_bpo_male[]', old('na_bpo_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('na_bpo_female[]', old('na_bpo_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('na_bpo_others[]', old('na_bpo_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('np_liph_male[]', old('np_liph_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('np_liph_female[]', old('np_liph_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('np_liph_others[]', old('np_liph_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>