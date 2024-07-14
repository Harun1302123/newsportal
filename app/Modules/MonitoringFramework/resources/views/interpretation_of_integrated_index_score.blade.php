@if ((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)
<table class="table table-bordered">
    <tr class="main-heading">
        <th>Year</th>
        <th>Quarter</th>
        <th>Indicator Score</th>
        <th>Goal Tracking Score</th>
        <th>Total Score</th>
        <th>Score of Integrated Index</th>
        <th>Interpretation</th>
        {{-- <th>Portal Status</th> --}}
        <th>Action</th>
    </tr>
    @forelse (approvedIndicatorYears() as $result)
    @php
        $quarter = $result->mef_quarter_id;
        $year = $result->year;
    @endphp
    @if (integratedIndexScore($year, $quarter))     
    @php
        $item = integratedIndexScore($year, $quarter);
        $dimensionInfo = $item['approved_indicator_info'] ? json_decode($item['approved_indicator_info']) : null;
        $indicator_tracking_score = $dimensionInfo ? ($dimensionInfo->usage_achieved_score_total+$dimensionInfo->access_achieved_score_total+$dimensionInfo->quality_achieved_score_total) : null;
        $goal_tracking_score = $item['approved_goal_tracking_info'] ?? null;
        $totalScore = number_format($indicator_tracking_score,2)+number_format($goal_tracking_score,2);
        $interpretationCondition = interpretationCondition($totalScore);
        $portalStatus = scoreStatusChecking($year, $quarter);
        $action_btn = '';
        if ($portalStatus == "Inactive") {
            $action_btn = "<button onclick='scoreRecordPublishAction($year, $quarter, $indicator_tracking_score, $goal_tracking_score)' class='btn btn-success btn-xs m-1'> Publish </button><br>"; 
        }

    @endphp
    <tr>
        <td>{{ $year ?? null }}</td>
        <td>{{ quarterText($quarter) ?? null }}</td>
        <td>{{ number_format($indicator_tracking_score,2)??null }}</td>
        <td>{{ number_format($goal_tracking_score,2)??null }}</td>
        <td>{{ $totalScore ?? null }}</td>
        <td>{!! $interpretationCondition['integratedIndex'] ?? null !!}</td>
        <td>{!! $interpretationCondition['interpretation'] ?? null !!}</td>
        {{-- <td>{{ $portalStatus ?? null }}</td> --}}
        <td>{!! $action_btn ?? null !!}</td>
    </tr>
    @endif
    @empty
        
    @endforelse
        
</table>
@endif
