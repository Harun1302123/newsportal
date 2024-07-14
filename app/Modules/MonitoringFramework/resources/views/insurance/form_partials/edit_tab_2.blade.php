<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">2. Balance with insurance companies
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
                @if ($master_data->MefInsuranceDetailsTable2->count())
                    @foreach ($master_data->MefInsuranceDetailsTable2->sortBy('division_id')->all() as $item)
                                <tr>
                                    <th rowspan="">{{ $item->division->area_nm ?? null  }}</th>

                                    <th>{{ $item->district->area_nm ?? null }}</th>
                                    <input type="hidden" name="district_id_1_1[]"
                                        value="{{ $district->area_id ?? null }}">
                                    <input type="hidden" name="division_id_1_1[]"
                                        value="{{ $item->division->area_nm ?? null}}">
                                    <input type="hidden" name="mef_insurance_details_table_2_id[]" value="{{ $item->id??null }}"> 
                                    <td>{!! Form::number('tlip_male_1_1[]', $item->tlip_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('tlip_female_1_1[]', $item->tlip_female ?? null, [
                                        'class' => 'form-control input-md custom-input',
                                    ]) !!}</td>
                                    <td>{!! Form::number('tlip_others_1_1[]',$item->tlip_others ?? null, [
                                        'class' => 'form-control input-md custom-input',
                                    ]) !!}</td>
                                    <td>{!! Form::number('mip_male_1_1[]', $item->mip_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('mip_female_1_1[]', $item->mip_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('mip_others_1_1[]', $item->mip_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('hp_male_1_1[]', $item->hp_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('hp_female_1_1[]', $item->hp_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('hp_others_1_1[]', $item->hp_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('ap_total_number_1_1[]', $item->ap_total_number ?? null, [
                                        'class' => 'form-control input-md custom-input',
                                    ]) !!}</td>
                                    <td>{!! Form::number('nfp_total_number_1_1[]', $item->nfp_total_number ?? null, [
                                        'class' => 'form-control input-md custom-input',
                                    ]) !!}</td>
                                </tr>
                            @endforeach
                        @endif

            </table>
        </div>
    </div>
</div>
