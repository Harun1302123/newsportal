<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2. Balance/Outstanding Amount
                </li>
            </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="4">Balance of NSC</th>
                        <th class="text-center" colspan="3">Deposit Balance with BPO</th>
                        <th class="text-center" colspan="3">Balance of Postal Life Insurance Policies</th>
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
                                        <th rowspan="{{ $totalData }}">{{ $division->area_nm ?? null }}</th>
                                    @endif
                                    <th>{{ $district->area_nm ?? null }}</th>
                                    <input type="hidden" name="district_id_1_1[]"
                                        value="{{ $district->area_id ?? null }}">
                                    <input type="hidden" name="division_id_1_1[]"
                                        value="{{ $division->area_id ?? null }}">
                                    <td>{!! Form::number('bo_nsc_male_1_1[]', old('bo_nsc_male_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bo_nsc_female_1_1[]', old('bo_nsc_female_1_1[]'),['class' => 'form-control input-md custom-input',]) !!}</td>
                                    <td>{!! Form::number('bo_nsc_others_1_1[]', old('bo_nsc_others_1_1[]'), ['class' => 'form-control input-md custom-input',]) !!}</td>
                                    <td>{!! Form::number('bo_nsc_joint_1_1[]', old('bo_nsc_joint_1_1[]'), ['class' => 'form-control input-md custom-input',])!!}</td>
                                    <td>{!! Form::number('db_bpo_male_1_1[]', old('db_bpo_male_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('db_bpo_female_1_1[]', old('db_bpo_female_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('db_bpo_others_1_1[]', old('db_bpo_others_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bp_lip_male_1_1[]', old('bp_lip_male_1_1[]'), ['class' => 'form-control input-md custom-input'])!!}</td>
                                    <td>{!! Form::number('bp_lip_female_1_1[]', old('bp_lip_female_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bp_lip_others_1_1[]', old('bp_lip_others_1_1[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
