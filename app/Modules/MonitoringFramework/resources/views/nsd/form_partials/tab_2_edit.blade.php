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
                @if ($master_data->mefNsdDetailsTable2->count())
                    @foreach ($master_data->mefNsdDetailsTable2->sortBy('division_id')->all() as $item1)
                        <tr>
                            <th>{{ $item1->division->area_nm ?? null }}</th>
                            <th>{{ $item1->district->area_nm ?? null }}</th>
                            <input type="hidden" name="mef_nsd_details_table_1_1_id[]" value="{{ $item1->id ?? null }}">
                            <input type="hidden" name="division_id_1_1[]" value="{{ $item1->division->area_id??null }}">
                            <input type="hidden" name="district_id_1_1[]" value="{{ $item1->district->area_id??null }}">
                            <td>{!! Form::number('bo_nsc_male_1_1[]', $item1->bo_nsc_male?? old('bo_nsc_male_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bo_nsc_female_1_1[]', $item1->bo_nsc_female ?? old('bo_nsc_female_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bo_nsc_others_1_1[]', $item1->bo_nsc_others ?? old('bo_nsc_others_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bo_nsc_joint_1_1[]', $item1->bo_nsc_joint?? old('bo_nsc_joint_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('db_bpo_male_1_1[]',   $item1->db_bpo_male?? old('db_bpo_male_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('db_bpo_female_1_1[]',$item1->db_bpo_female ?? old('db_bpo_female_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('db_bpo_others_1_1[]', $item1->db_bpo_others ?? old('db_bpo_others_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bp_lip_male_1_1[]', $item1->bp_lip_male ?? old('bp_lip_male_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bp_lip_female_1_1[]', $item1->bp_lip_female ?? old('bp_lip_female_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('bp_lip_others_1_1[]', $item1->bp_lip_others?? old('bp_lip_others_1_1'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
