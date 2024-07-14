@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row">
        @php

        @endphp
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>Setwise Data Preview</strong></h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center">Set Name</th>
                                    <th class="text-center">Maximum Score</th>
                                    <th class="text-center">Benchmark / Allocated Score</th>
                                    <th class="text-center">Total Population by Census</th>
                                </tr>
                               
                                @if ($master_data->MefSetManualDataDetailsRecord->count())
                                    @foreach ($master_data->MefSetManualDataDetailsRecord->sortBy('set_id')->all() as $item)
                                        @php
                                            $setWiseInfo = json_decode($item->set_info) ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->mefSet->title ?? null }}</td>
                                            <td>{{ $setWiseInfo->maximum_score ?? null }}</td>
                                            <td>{{ $setWiseInfo->allocated_score ?? null }}</td>
                                            @if ($item->mefSet->name == "A") 
                                                <td>{{ $setWiseInfo->set_a_total_population ?? null }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        </tr>
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
