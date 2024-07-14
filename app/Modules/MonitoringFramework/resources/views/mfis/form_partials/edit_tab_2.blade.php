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
                @if ($master_data->mefMfisDetailsTable2->count())
                    @foreach ($master_data->mefMfisDetailsTable2->sortBy('division_id')->all() as $item)
                    
                    <tr>
                        <th>{{ $item->division->area_nm??null }}</th>
                        <th>{{ $item->district->area_nm??null }}</th>
                        <input type="hidden" name="mef_mfis_details_table_1_1_id[]" value="{{ $item->id??null }}">
                        <input type="hidden" name="district_id_1_1[]" value="{{ $item->division_id??null }}">
                        <input type="hidden" name="division_id_1_1[]" value="{{ $item->district_id??null }}">
                        <td>{!! Form::number('bta_male[]', $item->bta_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bta_female[]', $item->bta_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bta_others[]', $item->bta_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bsa_male[]', $item->bsa_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bsa_female[]', $item->bsa_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('bsa_others[]', $item->bsa_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('obtla_male[]', $item->obtla_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('obtla_female[]', $item->obtla_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('obtla_others[]', $item->obtla_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('oblla_male[]', $item->oblla_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('oblla_female[]', $item->oblla_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('oblla_others[]', $item->oblla_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
