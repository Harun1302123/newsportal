<div class="card-body">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">Goal Tracking</li>
            </ul>
            <table class="table table-bided">
                <tr class="main-heading">
                    <th class="custom-width" style="width: 200px; text-align: left;">Goals</th>
                    <th class="custom-width" style="width: 250px; text-align: left;">Targets</th>
                    <th>Implementation Status</th>
                    <th>New Policy/Guidelines Issued or Action Taken</th>
                    <th>Visible Operational Automation Took Place</th>
                    <th>New Inclusive Financial Product Introduced</th>
                    <th>Score</th>
                    <th>Total Score</th>
                    <th>Maximum Score</th>
                    <th>Converted Score</th>
                    <th>Benchmark Score</th>
                    <th>Weighted Score</th>
                </tr>
                @php

                    $unique_goals = $master_data->goalDetailsRecord->pluck('goal_id')->unique();
                    $totalTargetWithoutGoal12 = collectionWiseCountTarget($master_data->goalDetailsRecord, 'goal_id', 12);
                    $totalScoreWithoutGoal12 = collectionWiseSumScore($master_data->goalDetailsRecord, 'goal_id', 12);
                    $totalScoreGoal12 = collectionWiseSumScore($master_data->goalDetailsRecord, 'goal_id', 12, '=');
                    $maximumScoreWithoutGoal12 = getMaximumScoreData( $master_data->year, $master_data->mef_quarter_id, 'without_goal_12' );
                    $maximumScoreGoal12 = getMaximumScoreData( $master_data->year, $master_data->mef_quarter_id, 'goal_12' );
                    $benchmarkWithoutGoal12 = getBenchmarkData( $master_data->year, $master_data->mef_quarter_id, 'without_goal_12' );
                    $benchmarkGoal12 = getBenchmarkData( $master_data->year, $master_data->mef_quarter_id, 'goal_12' );
                    $WeightedScoreWithoutGoal12 = number_format(($totalScoreWithoutGoal12 >= $benchmarkWithoutGoal12) ? 24 : ($totalScoreWithoutGoal12/$benchmarkWithoutGoal12)*24, 2);
                    $WeightedScoreGoal12 = number_format((($totalScoreGoal12/10) >= $benchmarkGoal12) ? 1 : (($totalScoreGoal12/10)/$benchmarkGoal12), 2);
                    $totalWeightedScore = $WeightedScoreWithoutGoal12 + $WeightedScoreGoal12;
                @endphp
                @forelse ($master_data->goalDetailsRecord as $key => $item)
                @php
                    $goal_wise_info = json_decode($item->goal_wise_info);
                    $rowSpanValue = $master_data->goalDetailsRecord->where("goal_id", $item->goal_id)->count();
                @endphp
                <tr>
                    @if (isset($unique_goals[$key]))
                    <th style="text-align: left;" rowspan="{{ $rowSpanValue }}">{{ $item->goal->id ?? null }} {{ $item->goal->title_en ?? null }}</th>
                    @endif
                    <td style="text-align: left;">{{ $item->target->target_number_en ?? null }} {{ $item->target->title_en ?? null }}</td>
                    @if ($item->goal->id != 12)
                    <td>{{ implementationStatusInfo($goal_wise_info->implementation_status) ?? null }}</td>
                    <td colspan="3"></td>
                    @else
                    <td></td>
                    <td>{{ goal12StatusInfo($goal_wise_info->goal12_policy_status) ?? null }}</td>
                    <td>{{ goal12StatusInfo($goal_wise_info->goal12_inclusive_status) ?? null }}</td>
                    <td>{{ goal12StatusInfo($goal_wise_info->goal12_operational_status) ?? null }}</td>
                    @endif
                    <td>{{ $item->score ?? null }}</td>
                    @if ($key < 1 && $item->goal->id != 12)
                    <input type="hidden" name="totalScoreWithoutGoal12" value="{{ $totalScoreWithoutGoal12 ?? null }}">
                    <input type="hidden" name="maximumScoreWithoutGoal12" value="{{ $maximumScoreWithoutGoal12 ?? null }}">
                    <input type="hidden" name="convertedScoreWithoutGoal12" value="{{ $totalScoreWithoutGoal12 ?? null }}">
                    <input type="hidden" name="benchmarkWithoutGoal12" value="{{ $benchmarkWithoutGoal12 ?? null }}">
                    <input type="hidden" name="WeightedScoreWithoutGoal12" value="{{ $WeightedScoreWithoutGoal12 ?? null }}">
                    <td rowspan="{{ $totalTargetWithoutGoal12 }}">{{ $totalScoreWithoutGoal12 ?? null }}</td>
                    <td rowspan="{{ $totalTargetWithoutGoal12 }}">{{ $maximumScoreWithoutGoal12 ?? null }}</td>
                    <td rowspan="{{ $totalTargetWithoutGoal12 }}">{{ $totalScoreWithoutGoal12 ?? null }}</td>
                    <td rowspan="{{ $totalTargetWithoutGoal12 }}">{{ $benchmarkWithoutGoal12 ?? null }}</td>
                    <td rowspan="{{ $totalTargetWithoutGoal12 }}">{{ $WeightedScoreWithoutGoal12 ?? null }}</td>
                    @elseif ($item->goal->id == 12)
                    <input type="hidden" name="totalScoreGoal12" value="{{ $totalScoreGoal12 ?? null }}">
                    <input type="hidden" name="maximumScoreGoal12" value="{{ $maximumScoreGoal12 ?? null }}">
                    <input type="hidden" name="convertedScoreGoal12" value="{{ $totalScoreGoal12/10 ?? null }}">
                    <input type="hidden" name="benchmarkGoal12" value="{{ $benchmarkGoal12 ?? null }}">
                    <input type="hidden" name="WeightedScoreGoal12" value="{{ $WeightedScoreGoal12 ?? null }}">
                    <td rowspan="{{ $item->goal->targets->count() }}">{{ $totalScoreGoal12 ?? null }}</td>
                    <td rowspan="{{ $item->goal->targets->count() }}">{{ $maximumScoreGoal12 ?? null }}</td>
                    <td rowspan="{{ $item->goal->targets->count() }}">{{ $totalScoreGoal12/10 ?? null }}</td>
                    <td rowspan="{{ $item->goal->targets->count() }}">{{ $benchmarkGoal12 ?? null }}</td>
                    <td rowspan="{{ $item->goal->targets->count() }}">{{ $WeightedScoreGoal12 ?? null }}</td>
                    @endif
                </tr>
                @empty

                @endforelse
                <tr>
                    <input type="hidden" name="totalWeightedScore" value="{{ $totalWeightedScore ?? null }}">
                    <th class="text-center" colspan="12">Total Weighted Score : {{ $totalWeightedScore ?? null }}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-left">

    </div>
    <div class="float-right">
        {{-- <button type="submit" class="btn btn-primary">Publish</button> --}}
    </div>
    <div class="clearfix"></div>
</div>
