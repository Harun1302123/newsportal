<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    1. Number of Account with Cooperative Societies
                </li>
            </ul>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="3">Total Number of Member</th >
                        <th class="text-center" colspan="3">Total Number of Accounts</th >
                        <th class="text-center" colspan="3">Number of Savings Accounts</th >
                        <th class="text-center" colspan="3">Number of Loan Accounts</th >
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
                @if ($data->mefCooperativesDetailsTable1->count())
                    @foreach ($data->mefCooperativesDetailsTable1->sortBy('division_id')->all() as $item)
                                <tr>
                                    <th>{{ $item->division->area_nm ?? null }}</th>
                                    <th>{{ $item->district->area_nm ?? null }}</th>
                                    <td>
                                        <input type="hidden" name="division_id[]" value="{{ $item->division->area_id??null }}">
                                        <input type="hidden" name="district_id[]" value="{{ $item->district->area_id??null }}">
                                        {!! Form::number('tnm_male[]', $item->tnm_male ?? old('tnm_male'), ['class' => 'form-control input-md custom-input']) !!}
                                    </td>
                                    <td>{!! Form::number('tnm_female[]', $item->tnm_female ?? old('tnm_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('tnm_others[]', $item->tnm_others ?? old('tnm_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('tna_male[]',  $item->tna_male ?? old('tna_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('tna_female[]', $item->tna_female ?? old('tna_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('tna_others[]', $item->tna_others ?? old('tna_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('nsa_male[]', $item->nsa_male ?? old('nsa_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nsa_female[]', $item->nsa_female ?? old('nsa_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nsa_others[]', $item->nsa_others ?? old('nsa_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('nla_male[]', $item->nla_male ?? old('nla_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nla_female[]', $item->nla_female ?? old('nla_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nla_others[]', $item->nla_others ?? old('nla_others') , ['class' => 'form-control input-md custom-input']) !!}</td>
                                </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
