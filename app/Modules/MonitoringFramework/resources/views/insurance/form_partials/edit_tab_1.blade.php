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
                @if ($master_data->MefInsuranceDetailsTable1->count())
                    @foreach ($master_data->MefInsuranceDetailsTable1->sortBy('division_id')->all() as $item)

                        <tr>
                            <th rowspan="" >{{ $item->division->area_nm ?? null }}</th>

                            <th>{{ $item->district->area_nm ?? null }}</th>
                            <input type="hidden" name="district_id[]" value="{{ $district->area_id??null }}">
                            <input type="hidden" name="division_id[]" value="{{ $division->area_id??null }}">
                            <input type="hidden" name="mef_insurance_details_table_1_id[]" value="{{ $item->id??null }}">                           
                            <td>{!! Form::number('tlip_male[]', $item->tlip_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('tlip_female[]', $item->tlip_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('tlip_others[]', $item->tlip_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_male[]',$item->mip_male ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_female[]',  $item->mip_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('mip_others[]', $item->mip_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_male[]', $item->hp_male ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_female[]',  $item->hp_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('hp_others[]', $item->hp_total ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ap_total_number[]', $item->ap_total_number ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nfp_total_number[]',$item->nfp_total_number ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
