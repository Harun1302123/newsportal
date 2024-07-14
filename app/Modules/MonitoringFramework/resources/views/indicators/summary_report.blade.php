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
                                    <th style="min-width: 120px;">Data Field</th>
                                    <th style="min-width: 120px;">Source</th>
                                    <th class="text-center" colspan="6">Visual part</th >
                                    <th class="text-center" style="min-width: 150px;" colspan="4">Background part</th >
                                </tr>

                                @if ($set_indicator_details->count())
                                    @foreach ($set_indicator_details as $set)
                                        <tr class="mef-set-heading" >
                                            <th ></th >
                                            <th ></th>
                                            <th>{{ $set['dimension_name']??null }}</th>
                                            <th style="min-width: 500px;">{{ $set['set_title']??null }}</th>                                            
                                            <th style="min-width: 100px;">Time T-1</th >
                                            <th style="min-width: 100px;">Time T</th >
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
                                                <td></td>
                                                <td>{{ $indicator['org_type']??null }}</td>
                                                <td>{{ $set['dimension_name']??null }}</td>
                                                <td>{{ $indicator['indicator_name']??null }}</td>
                                                <td>1</td>
                                                <td>1</td>
                                                @if ($set['set_name'] == 'A' && $key < 1)
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>                                    
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">100%</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">14.30%</td>  
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">15</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">16</td>  
                                                @elseif ($set['set_name'] != 'A' )
                                                    <td>1</td>
                                                    <td>1</td>
                                                    @if ($key < 1)
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>
                                                    <td rowspan="{{ $rowSpanValue }}" class="text-center align-middle">1</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
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
