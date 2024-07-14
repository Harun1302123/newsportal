<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2. Balance/Outstanding amount with MFIs
                </li>
              </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="3">Balance with Total Accounts</th >
                        <th class="text-center" colspan="3">Balance with Savings Account</th >
                        <th class="text-center" colspan="3">Number of Total Loan Accounts</th >
                        <th class="text-center" colspan="3">Bank/NBFI-MFI Linkage Loan Accounts</th >
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
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
                            <input type="hidden" name="district_id_1_1[]" value="{{ $district->area_id??null }}">
                            <input type="hidden" name="division_id_1_1[]" value="{{ $division->area_id??null }}">
                            <td>{!! Form::number('bta_male[]', old('bta_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bta_female[]', old('bta_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bta_others[]', old('bta_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bsa_male[]', old('bsa_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bsa_female[]', old('bsa_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bsa_others[]', old('bsa_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('obtla_male[]', old('obtla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('obtla_female[]', old('obtla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('obtla_others[]', old('obtla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('oblla_male[]', old('oblla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('oblla_female[]', old('oblla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('oblla_others[]', old('oblla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
