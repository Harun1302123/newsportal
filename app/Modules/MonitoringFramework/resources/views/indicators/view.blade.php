@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>Monitoring Framework</strong></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center font-weight-bold">M & E
                                </li>
                              </ul>
                            <table class="table table-bordered">
                                <tr class="main-heading">
                                    <th class="text-center" colspan="6">Visual part</th >
                                    <th class="text-center" style="min-width: 150px;" colspan="4">Background part</th >
                                </tr>

                                @if ($master_data['details']->count())
                                    @php
                                        $dimensionInfo = $master_data['dimension_wise_info'] ? json_decode($master_data['dimension_wise_info']) : null;
                                    @endphp
                                    @foreach ($master_data['details'] as $k => $set)
                                        <tr class="mef-set-heading" >
                                            <th>{{ $set['dimension_name']??null }}</th>
                                            <th style="min-width: 500px;">{{ $set['set_title']??null }}</th>                                            
                                            <th style="min-width: 100px;">{{ ($prev_year ? ($prev_year ." ". $prevQuarterText) : 'Time T-1') }}</th >
                                            <th style="min-width: 100px;">{{ ($year ? ($year ." ". $quarterText) : 'Time T') }}</th >
                                            @if ($set['set_name'] == 'A')
                                                <th style="min-width: 100px;">Total</th >
                                                <th style="min-width: 250px;">Total Population by Census</th >
                                                <th style="min-width: 270px;">Total Accounts/Total Population</th >
                                                <th style="min-width: 250px;">Benchmark (dec-23)</th >
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
                                            @endphp
                                            @foreach ($set['indicators'] as $key => $indicator)
                                            <tr class="indicator-heading">
                                                <td>{{ $set['dimension_name']??null }}</td>
                                                <td>{{ $indicator['indicator_name']??null }}</td>
                                                <td>{{ $indicator['previous_value']??null }}</td>
                                                <td>{{ $indicator['current_value']??null }}</td>
                                                @if ($key < 1)
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->total_current_value??null }}</td>                                    
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->total_population_by_census??null }}</td>                                    
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->total_accounts_population??null }} %</td>                                    
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->benchmark??null }} %</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->maximum_score??null }}</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->achieved_score??null }}</td>
                                                @elseif ($set['set_name'] != 'A' )
                                                    <td>{{ $indicator['changes_percentage']??null }}</td>
                                                    <td>{{ $indicator['score']??null }}</td>
                                                    @if (in_array($key, eachSetFirstIndicatorIds()))
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->total_score??null }}</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->maximum_score??null }}</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->allocated_score??null }}</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">{{ $set['set_wise_info']->achieved_score??null }}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            @endforeach
                                        @endif
                                        @if (8 == $k)
                                        <tr>
                                            <th colspan="8" class="text-center">Total: </th>
                                            <th class="text-center">{{  $dimensionInfo->usage_allocated_score_total ?? null }}</th>
                                            <th class="text-center">{{  $dimensionInfo->usage_achieved_score_total ?? null }}</th>
                                        </tr>
                                        @endif
                                        @if (9 == $k)
                                        <tr>
                                            <th colspan="8" class="text-center">Total: </th>
                                            <th class="text-center">{{  $dimensionInfo->access_allocated_score_total ?? null }}</th>
                                            <th class="text-center">{{  $dimensionInfo->access_achieved_score_total ?? null }}</th>
                                        </tr>
                                        @endif
                                        @if (15 == $k)
                                        <tr>
                                            <th colspan="8" class="text-center">Total: </th>
                                            <th class="text-center">{{  $dimensionInfo->quality_allocated_score_total ?? null }}</th>
                                            <th class="text-center">{{  $dimensionInfo->quality_achieved_score_total ?? null }}</th>
                                        </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <th colspan="8" class="text-center">Access+Usage+Quality: </th>
                                        <th class="text-center">{{  ($dimensionInfo->usage_allocated_score_total+$dimensionInfo->access_allocated_score_total+$dimensionInfo->quality_allocated_score_total) ?? null }}</th>
                                        <th class="text-center">{{  ($dimensionInfo->usage_achieved_score_total+$dimensionInfo->access_achieved_score_total+$dimensionInfo->quality_achieved_score_total) ?? null }}</th>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route($list_route) }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                            Close
                        </a>
                    </div>
                    <div class="float-right">
      
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection <!--content section-->
