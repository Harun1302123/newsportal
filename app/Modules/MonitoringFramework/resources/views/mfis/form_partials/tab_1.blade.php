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
                            <th rowspan="{{ $totalData }}" >{{ $division->area_nm??null }}</th>
                            @endif
                            <th>{{ $district->area_nm??null }}</th>
                            <input type="hidden" name="division_id[]" value="{{ $division->area_id??null }}">
                            <input type="hidden" name="district_id[]" value="{{ $district->area_id??null }}">
                            <td>{!! Form::number('nta_male[]', old('nta_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nta_female[]', old('nta_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nta_others[]', old('nta_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_male[]', old('nba_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_female[]', old('nba_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('nba_others[]', old('nba_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_male[]', old('ntla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_female[]', old('ntla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('ntla_others[]', old('ntla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_male[]', old('blla_male[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_female[]', old('blla_female[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                            <td>{!! Form::number('blla_others[]', old('blla_others[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                @endif


{{--
                <tr>
                    <td class="text-center" colspan="2">Totals</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr> --}}
            </table>
        </div>
    </div>
</div>
