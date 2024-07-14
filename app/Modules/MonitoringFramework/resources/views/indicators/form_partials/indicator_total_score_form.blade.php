<style>
    .table-container {
        position: relative;
    }

    .table-responsive {
        display: block;
        width: 100%;
        max-height: calc(100vh - 20px); /* Adjust the max-height as needed, subtracting any additional margin or padding */
        overflow-x: auto;
    }

    .bottom-scrollbar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow-x: auto;
    }

</style>
<div class="card-body">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">M & E</li>
            </ul>
            <table class="table table-bordered">
                <tr class="main-heading">
                    <th class="text-center" colspan="6">Visual part</th >
                    <th class="text-center" style="min-width: 150px;" colspan="4">Background part</th >
                </tr>

                @if ($set_indicator_details->count())
                    @php
                        $usageAllocatedScore = 0;
                        $accessAllocatedScore = 0;
                        $qualityAllocatedScore = 0;
                        $usageAchievedScore = 0;
                        $accessAchievedScore = 0;
                        $qualityAchievedScore = 0;
                    @endphp
                    @foreach ($set_indicator_details as $k => $set)
                        <input type="hidden" name="set_id[]" value="{{ $set['set_id'] ?? null }}">
                        <tr class="mef-set-heading" >
                            <th>{{ $set['dimension_name']??null }}</th>
                            <th style="min-width: 500px;">{{ $set['set_title']??null }}</th>
                            <th style="min-width: 100px;">{{ ($prev_year ? ($prev_year ." ". $prevQuarterText) : 'Time T-1') }}</th >
                            <th style="min-width: 100px;">{{ ($year ? ($year ." ". $quarterText) : 'Time T') }}</th >
                            @if ($set['set_name'] == 'A')
                                <th style="min-width: 100px;">Total</th >
                                <th style="min-width: 250px;">Total Population by Census</th >
                                <th style="min-width: 270px;">Total Accounts/Total Population</th >
                                <th style="min-width: 250px;">Benchmark</th >
                                <th style="min-width: 250px;">Maximum score</th >
                                <th style="min-width: 250px;">Achieved Score</th >
                            @else
                                <th style="min-width: 100px;">% Change</th >
                                <th style="min-width: 250px;">Score</th >
                                <th style="min-width: 270px;">Total Score</th >
                                <th style="min-width: 250px;">Maximum Score</th >
                                <th style="min-width: 250px;">Allocated Score</th >
                                <th style="min-width: 250px;">Achieved Score</th >
                            @endif
                        </tr>

                        @if ($set['indicators']->count())
                            @php
                                $rowSpanValue = $set['indicators']->count() ?? 0;
                                $previousValueArray = [];
                                $currentValueArray = [];
                                $changesPercentage = [];
                                $score = [];
                                $totalCurrentValue = 0;
                                $totalScore = 0;
                                $setWiseInfo = (($getSetWiseManualData->count()) ? json_decode($getSetWiseManualData[$set['set_id']]) : null);
                                $maximumScore = $setWiseInfo->maximum_score ?? null;
                                $allocatedScore = $setWiseInfo->allocated_score ?? null;

                                foreach ($set['indicators'] as $key => $indicator) {
                                    $currentValue = 0;
                                    if ($indicator['is_nau'] == 1) {
                                        $currentValue = getIndicatorNauValue($indicator['indicator_id'], $indicator['source_table'], $indicator['source_column'], $indicator['label_column'], $indicator['label_id'], $quarter, $year);
                                    }elseif ($indicator['is_multiple_column'] == 1) {
                                        $currentValue = getIndicatorValueMultipleColumnWise(json_decode($indicator['source_table']), json_decode($indicator['source_column']), $indicator['label_column'], $indicator['label_id'], $quarter, $year);
                                    }else {
                                        $currentValue = getIndicatorValueTableWise($indicator['source_table'], $indicator['source_column'], $indicator['label_column'], $indicator['label_id'], $quarter, $year);
                                    }
                                    $prevValue = null;
                                    if ($indicator['is_nau'] == 1) {
                                        $prevValue = getIndicatorNauValue($indicator['indicator_id'], $indicator['source_table'], $indicator['source_column'], $indicator['label_column'], $indicator['label_id'], $prevQuarter, $prev_year);
                                    }elseif ($indicator['is_multiple_column'] == 1) {
                                        $prevValue = getIndicatorValueMultipleColumnWise(json_decode($indicator['source_table']), json_decode($indicator['source_column']), $indicator['label_column'], $indicator['label_id'], $prevQuarter, $prev_year);
                                    }else {
                                        $prevValue = getIndicatorValueTableWise($indicator['source_table'], $indicator['source_column'], $indicator['label_column'], $indicator['label_id'], $prevQuarter, $prev_year);
                                    }
                                    $totalCurrentValue += $currentValue;
                                    $previousValueArray[$key] = $prevValue;
                                    $currentValueArray[$key] = $currentValue;
                                    // if $set['set_name'] != 'A' calculation
                                    $changesPercentage[$key] = null;
                                    if ($previousValueArray[$key]) {
                                        $changesPercentage[$key] = ($currentValueArray[$key] - $previousValueArray[$key]) / $previousValueArray[$key];
                                    }
                                    $score[$key] = 0;
                                    if ($changesPercentage[$key] > 0) {
                                        $score[$key] = 1;
                                    }elseif ($changesPercentage[$key] < 0) {
                                        $score[$key] = -1;
                                    }
                                    if (in_array($set['set_name'], ['K', 'L'])) {
                                        if ($changesPercentage[$key] > 0) {
                                            $score[$key] = -1;
                                        }elseif ($changesPercentage[$key] < 0) {
                                            $score[$key] = 1;
                                        }
                                    }
                                    $totalScore += $score[$key];
                                }
                            @endphp
                            @foreach ($set['indicators'] as $key => $indicator)
                                @php
                                    $previousValue = $previousValueArray[$key]??null;
                                    $currentValue = $currentValueArray[$key]??null;
                                    $changesPercentage = null;
                                    if ($previousValue) {
                                        $changesPercentage = ($currentValue - $previousValue) / $previousValue;
                                    }
                                    $achievedScore = null;
                                    if ($maximumScore) {
                                        $achievedScore = ($totalScore/$maximumScore)*$allocatedScore;
                                    }
                                    if ($totalScore == $maximumScore) {
                                        $achievedScore = $allocatedScore;
                                    }

                                    if ($key < 1 && $set['set_name'] == 'J'){
                                        $accessAllocatedScore += $allocatedScore;
                                        $accessAchievedScore += $achievedScore;
                                    }
                                    if ($key < 1 && in_array($set['set_name'], usageDimensionSets())){
                                        $usageAllocatedScore += $allocatedScore;
                                        $usageAchievedScore += $achievedScore;
                                    }
                                    if ($key < 1 && in_array($set['set_name'], qualityDimensionSets())){
                                        $qualityAllocatedScore += $allocatedScore;
                                        $qualityAchievedScore += $achievedScore;
                                    }
                                @endphp
                            <tr class="indicator-heading">
                                <td>{{ $set['dimension_name'] ?? null }}</td>
                                <td>{{ $indicator['indicator_name'] ?? null }}</td>
                                <td>{{ $previousValue ?? null }}</td>
                                <input type="hidden" name="indicator_id[]" value="{{ $indicator['indicator_id'] }}">
                                <input type="hidden" name="indicator_set_id[]" value="{{ $set['set_id'] }}">
                                <input type="hidden" name="previous_value[]" value="{{ $previousValue ?? null }}">
                                <input type="hidden" name="current_value[]" value="{{ $currentValue ?? null }}">
                                <input type="hidden" name="changes_percentage[]" value="{{ number_format($changesPercentage, 2) ?? null }}">
                                <input type="hidden" name="score[]" value="{{ $score[$key] ?? null }}">
                                <td>{{ $currentValue ?? null }}</td>
                                @if ($set['set_name'] == 'A' && $key < 1)
                                    @php
                                        $set_a_maximum_score = $maximumScore ?? null;
                                        $totalPopulationByCensus = $setWiseInfo->set_a_total_population ?? null;
                                        $benchmark = getBenchmarkData( $year, $quarter, 'indicator_set_a' );
                                        $totalAccountsPopulation = null;
                                        if ($totalPopulationByCensus) {
                                            $totalAccountsPopulation = ($totalCurrentValue/$totalPopulationByCensus)*100;
                                        }
                                        $achievedScoreSetA = null;
                                        if ($benchmark) {
                                            $achievedScoreSetA = ($totalAccountsPopulation/$benchmark)*$maximumScore;
                                        }
                                        if ($totalAccountsPopulation >= $benchmark) {
                                            $achievedScoreSetA = $maximumScore;
                                        }

                                    @endphp
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $totalCurrentValue ?? null }}</td>
                                    <input type="hidden" name="set_a_total_current_value" value="{{ $totalCurrentValue ?? null }}">
                                    <input type="hidden" name="set_a_total_population_by_census" value="{{ $totalPopulationByCensus ?? null }}">
                                    <input type="hidden" name="set_a_total_accounts_population" value="{{ $totalAccountsPopulation ?? null }}">
                                    <input type="hidden" name="set_a_benchmark" value="{{ $benchmark ?? null }}">
                                    <input type="hidden" name="set_a_maximum_score" value="{{ $set_a_maximum_score }}">
                                    <input type="hidden" name="set_a_achieved_score" value="{{ number_format($achievedScoreSetA, 2) ?? null }}">
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $totalPopulationByCensus ?? null }}</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $totalAccountsPopulation ?? null }} %</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $benchmark ?? null }} %</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set_a_maximum_score ?? null }}</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ number_format($achievedScoreSetA, 2) ?? null }}</td>
                                @elseif ($set['set_name'] != 'A')
                                    <td>{{ number_format($changesPercentage, 2) ?? null }}</td>
                                    <td>{{ $score[$key] ?? null }}</td>
                                    @if ($key < 1)
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $totalScore ?? null }}</td>
                                    <input type="hidden" name="total_score[]" value="{{ $totalScore ?? null }}">
                                    <input type="hidden" name="maximum_score[]" value="{{ $maximumScore ?? null }}">
                                    <input type="hidden" name="allocated_score[]" value="{{ $allocatedScore ?? null }}">
                                    <input type="hidden" name="achieved_score[]" value="{{ number_format($achievedScore, 2) ?? null }}">
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $maximumScore ?? null }}</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $allocatedScore ?? null }}</td>
                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ number_format($achievedScore, 2) ?? null }}</td>
                                    @endif
                                @endif
                            </tr>
                            @endforeach
                        @endif
                        @if (8 == $k)
                        <tr>
                            <th colspan="8" class="text-center">Total: </th>
                            <th class="text-center">{{ ($set_a_maximum_score+$usageAllocatedScore) ?? null }}</th>
                            <th class="text-center">{{ number_format(($achievedScoreSetA+$usageAchievedScore), 2) ?? null }}</th>
                            <input type="hidden" name="usage_allocated_score_total" value="{{ ($set_a_maximum_score+$usageAllocatedScore) ?? null }}">
                            <input type="hidden" name="usage_achieved_score_total" value="{{ number_format(($achievedScoreSetA+$usageAchievedScore), 2) ?? null }}">
                        </tr>
                        @endif
                        @if (9 == $k)
                        <tr>
                            <th colspan="8" class="text-center">Total: </th>
                            <th class="text-center">{{ $accessAllocatedScore ?? null }}</th>
                            <th class="text-center">{{ number_format($accessAchievedScore, 2) ?? null }}</th>
                            <input type="hidden" name="access_allocated_score_total" value="{{ $accessAllocatedScore ?? null }}">
                            <input type="hidden" name="access_achieved_score_total" value="{{ number_format($accessAchievedScore, 2) ?? null }}">
                        </tr>
                        @endif
                        @if (15 == $k)
                        <tr>
                            <th colspan="8" class="text-center">Total: </th>
                            <th class="text-center">{{ $qualityAllocatedScore ?? null }}</th>
                            <th class="text-center">{{ number_format($qualityAchievedScore, 2) ?? null }}</th>
                            <input type="hidden" name="quality_allocated_score_total" value="{{ $qualityAllocatedScore ?? null }}">
                            <input type="hidden" name="quality_achieved_score_total" value="{{ number_format($qualityAchievedScore, 2) ?? null }}">
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th colspan="8" class="text-center">Access+Usage+Quality: </th>
                        <th class="text-center">{{ (($set_a_maximum_score+$usageAllocatedScore) ?? null)+($accessAllocatedScore ?? null)+($qualityAllocatedScore ?? null) }}</th>
                        <th class="text-center">{{ (number_format(($achievedScoreSetA+$usageAchievedScore), 2) ?? null)+(number_format($accessAchievedScore, 2) ?? null)+(number_format($qualityAchievedScore, 2) ?? null) }}</th>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>

<div class="card-footer">
    <div class="float-left">

    </div>
    <div class="float-right">
        <button type="submit" class="btn btn-primary">Publish</button>
    </div>
    <div class="clearfix"></div>
</div>

<script>
    $(document).ready(function() {
        // Attach a click event handler to the "Publish" button
        $('button[type="submit"]').click(function(e) {
            // Display a confirmation dialog
            var confirmation = confirm("Are you sure you want to publish?");

            if (!confirmation) {
                e.preventDefault();
            }
        });
    });
</script>
