<div id="tab_11" class="tab-pane">
    <ul class="list-group list-group-flush">
        <li class="list-group-item text-center font-weight-bold">
            3. Loan Classification
        </li>
    </ul>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="3">Loan/Investment Type</th>
                    <th class="text-center" colspan="10">Unclassified</th>
                    <th class="text-center" colspan="15">Classified</th>
                </tr>
                <tr>
                    <th class="text-center" colspan="5">Standard</th>
                    <th class="text-center" colspan="5">SMA</th>
                    <th class="text-center" colspan="5">SS</th>
                    <th class="text-center" colspan="5">DF</th>
                    <th class="text-center" colspan="5">B/L</th>
                </tr>
                <tr>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                    <th>Joint Account</th>
                    <th>Enterprise</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                    <th>Joint Account</th>
                    <th>Enterprise</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                    <th>Joint Account</th>
                    <th>Enterprise</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                    <th>Joint Account</th>
                    <th>Enterprise</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                    <th>Joint Account</th>
                    <th>Enterprise</th>
                </tr>
            </thead>
            @if ($master_data->mefNbfisDetailsTable3->count())
                @foreach($master_data->mefNbfisDetailsTable3 as $key => $item)
                    <tr>
                        <th style="min-width: 200px">{{$item->mefNbfisLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_3[]" value="{{ $item->mefNbfisLabel->id ?? null }}">
                        <input type="hidden" name="mef_nbfis_details_table_3_id[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('u_standard_male_3[]', $item->u_standard_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_standard_female_3[]', $item->u_standard_female ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('u_standard_others_3[]', $item->u_standard_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_standard_joint_3[]', $item->u_standard_joint ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                       <td>{!! Form::number('u_standard_enterprise_3[]', $item->u_standard_enterprise ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('u_sma_male_3[]', $item->u_sma_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_sma_female_3[]',$item->u_sma_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_sma_others_3[]',$item->u_sma_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_sma_joint_3[]', $item->u_sma_joint ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('u_sma_enterprise_3[]', $item->u_sma_enterprise ?? null, [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('c_ss_male_3[]', $item->c_ss_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_ss_female_3[]', $item->c_ss_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_ss_others_3[]', $item->c_ss_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_ss_joint_3[]', $item->c_ss_joint ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_ss_enterprise_3[]', $item->c_ss_enterprise ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_df_male_3[]', $item->c_df_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_df_female_3[]', $item->c_df_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_df_others_3[]', $item->c_df_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_df_joint_3[]', $item->c_df_joint ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_df_enterprise_3[]', $item->c_df_enterprise ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_bl_male_3[]', $item->c_bl_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_bl_female_3[]', $item->c_bl_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_bl_others_3[]',$item->c_bl_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_bl_joint_3[]', $item->c_bl_joint ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('c_bl_enterprise_3[]', $item->c_bl_enterprise ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                    @endforeach
                @endif
        </table>
    </div>
</div>
