@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row">
        @php
            // dd($data)
        @endphp
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>MFS Data Preview</strong></h5>
                    <div class="float-right">
                        @if (Auth::user()->user_role_id == 2 && $master_data->mef_process_status_id != 25)
                        {!! $approve_btn !!}
                        @elseif (Auth::user()->user_role_id == 7 && $master_data->mef_process_status_id != 25)
                        {!! $check_btn !!}
                        @endif
                        {!! $excel_btn !!}
                        {!! $explanation_btn !!}

                    </div>
                </div>

                {!! rejectCardInfo($master_data->reject_reason, $master_data->id, $service_id, $master_data->mef_process_status_id) !!}

                @include('MonitoringFramework::mfs.view_details')

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('mfs.list') }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                            Close</a>
                    </div>
                    <div class="float-right">

                        <a href="{{ route('mfs.list') }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                            Close</a>


                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection <!--content section-->
