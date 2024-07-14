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
                    <h5 class="card-title"><strong>Indicator Data Preview</strong></h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center">Indicator Name</th>
                                    <th class="text-center">Indicator Value</th>
                                </tr>
                               
                                @if ($master_data->MefIndicatorManualDataDetailsRecord->count())
                                    @foreach ($master_data->MefIndicatorManualDataDetailsRecord->sortBy('indicator_id')->all() as $item)
                                        <tr>
                                            <td>{{ $item->mefIndicator->name ?? null }}</td>
                                            <td>{{ $item->indicator_value ?? null }}</td>
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
