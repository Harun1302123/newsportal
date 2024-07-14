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
                @if ($data->mefCooperativesDetailsTable2->count())
                    @foreach ($data->mefCooperativesDetailsTable2->sortBy('division_id')->all() as $item1)
                        <tr>
                            <th>{{ $item1->division->area_nm ?? null }}</th>
                            <th>{{ $item1->district->area_nm ?? null }}</th>
                                    <input type="hidden" name="division_id_1[]" value="{{ $item1->division->area_id??null }}">
                                    <input type="hidden" name="district_id_1[]" value="{{ $item1->district->area_id??null }}">

                                    <td>{!! Form::number('dbtm_male[]', $item1->dbtm_male ?? old('dbtm_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbtm_female[]', $item1->dbtm_female ?? old('dbtm_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbtm_others[]', $item1->dbtm_others ?? old('dbtm_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('bta_male[]', $item1->bta_male ?? old('bta_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bta_female[]', $item1->bta_female ?? old('bta_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('bta_others[]', $item1->bta_others ?? old('bta_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('dbsa_male[]', $item1->dbsa_male ?? old('dbsa_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbsa_female[]', $item1->dbsa_female ?? old('dbsa_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('dbsa_others[]', $item1->dbsa_others ?? old('dbsa_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                    <td>{!! Form::number('obla_male[]', $item1->obla_male ?? old('obla_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('obla_female[]', $item1->obla_female ?? old('obla_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('obla_others[]', $item1->obla_others ?? old('obla_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
