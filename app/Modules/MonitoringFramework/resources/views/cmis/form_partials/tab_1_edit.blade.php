<div id="tab_1" class="tab-pane active">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    1. Account Related Information
                </li>
            </ul>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Divison</th>
                    <th rowspan="2">District</th>
                    <th class="text-center" colspan="4">Number of BO Accounts</th >
                </tr>
                <tr>
                    <th>Male</th>
                    <th>Femate</th>
                    <th>Others</th>
                    <th>Institutional</th>
                </tr>
            </thead>
                @if ($data->mefCmisDetailsTable1->count())
                    @foreach ($data->mefCmisDetailsTable1->sortBy('division_id')->all() as $item)
                        <tr>
                                <th>{{ $item->division->area_nm??null }}</th>
                                <th>{{ $item->district->area_nm??null }}</th>
                                 <input type="hidden" name="mef_cmis_details_table_1_id[]" value="{{ $item->id??null }}">
                                    <td>
                                        <input type="hidden" name="division_id[]" value="{{ $item->division->area_id ?? null }}">
                                        <input type="hidden" name="district_id[]" value="{{ $item->district->area_id ?? null }}">
                                        {!! Form::number('nbo_accounts_male[]', $item->nbo_accounts_male ?? old('nbo_accounts_male'), ['class' => 'form-control input-md custom-input']) !!}
                                    </td>
                                    <td>{!! Form::number('nbo_accounts_female[]', $item->nbo_accounts_female ?? old('nbo_accounts_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nbo_accounts_others[]', $item->nbo_accounts_others ?? old('nbo_accounts_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                    <td>{!! Form::number('nbo_accounts_institutional[]', $item->nbo_accounts_institutional ?? old('nbo_accounts_institutional'), ['class' => 'form-control input-md custom-input']) !!}</td>

                                </tr>
                            @endforeach
                        @endif
            </table>
        </div>
    </div>
</div>
