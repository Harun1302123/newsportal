<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">1. Number of Account with MFIs
                </li>
              </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Divison</th>
                        <th rowspan="2">District</th>
                        <th class="text-center" colspan="3">Number of Total Accounts</th >
                        <th class="text-center" colspan="3">Number of Deposit Accounts</th >
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
    
                @if ($master_data->mefMfisDetailsTable1->count())
                    @foreach ($master_data->mefMfisDetailsTable1->sortBy('division_id')->all() as $item)
                        <tr>
                            <th>{{ $item->division->area_nm??null }}</th>
                            <th>{{ $item->district->area_nm??null }}</th>
                            <input type="hidden" name="mef_mfis_details_table_1_id[]" value="{{ $item->id??null }}">
                            <input type="hidden" name="division_id[]" value="{{ $item->division_id??null }}">
                            <input type="hidden" name="district_id[]" value="{{ $item->district_id??null }}">
                            <td>{!! Form::number('nta_male[]', $item->nta_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nta_female[]',$item->nta_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nta_others[]', $item->nta_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_male[]', $item->nba_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_female[]', $item->nba_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_others[]', $item->nba_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_male[]', $item->ntla_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_female[]', $item->ntla_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_others[]', $item->ntla_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_male[]', $item->blla_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_female[]', $item->blla_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_others[]', $item->blla_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>