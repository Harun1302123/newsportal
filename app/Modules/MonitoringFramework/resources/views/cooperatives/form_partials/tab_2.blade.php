<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    2. Balance/Outstanding amount with Cooperative Societies
                </li>
            </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="3">Deposit Balance of Total Member</th >
                        <th class="text-center" colspan="3">Balance with Total Accounts</th >
                        <th class="text-center" colspan="3">Deposit Balance of Savings Accounts</th >
                        <th class="text-center" colspan="3">Outstanding Balance of Loan Accounts</th >
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
                                    <input type="hidden" name="division_id_1[]" value="{{ $division->area_id }}">
                                    <input type="hidden" name="district_id_1[]" value="{{ $district->area_id }}">
                                    <td>{!! Form::number('dbtm_male[]', old('nta_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbtm_female[]', old('nta_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbtm_others[]', old('nta_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('bta_male[]', old('nba_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bta_female[]', old('nba_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bta_others[]', old('nba_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('dbsa_male[]', old('ntla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbsa_female[]', old('ntla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbsa_others[]', old('ntla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('obla_male[]', old('blla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('obla_female[]', old('blla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('obla_others[]', old('blla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
