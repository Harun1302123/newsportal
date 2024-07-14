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
                                    <th rowspan="{{ $totalData }}">{{ $division->area_nm??null }}</th>
                                @endif
                                <th>{{ $district->area_nm??null }}</th>
                                <td>
                                    <input type="hidden" name="division_id[]" value="{{ $division->area_id??null }}">
                                    <input type="hidden" name="district_id[]" value="{{ $district->area_id??null }}">
                                    {!! Form::number('nbo_accounts_male[]', old('nbo_accounts_male'), ['class' => 'form-control input-md custom-input']) !!}
                                </td>

                                <td>{!! Form::number('nbo_accounts_female[]', old('nbo_accounts_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                <td>{!! Form::number('nbo_accounts_others[]', old('nbo_accounts_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                <td>{!! Form::number('nbo_accounts_institutional[]', old('nbo_accounts_institutional'), ['class' => 'form-control input-md custom-input']) !!}</td>

                            </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>
