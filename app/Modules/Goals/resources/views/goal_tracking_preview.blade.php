@extends('layouts.admin')

@section('header-resources')
    <style>
        .main-heading .custom-width:first-child
        {
            width: auto!important;
            min-width: 200px;
        }
        .main-heading .custom-width:nth-child(2)
        {
            width: auto!important;
            min-width: 250px;
        }
    </style>

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header card-outline card-primary">
                <h5 class="card-title"><strong>{{ $card_title }}</strong></h5>

                <div class="float-right">
                    {!! $excel_btn !!}
                </div>
            </div>
            {!! Form::open([
                'route' => 'goals.publish_goal_tracking_data',
                'method' => 'post',
                'id' => 'form_id',
                'role' => 'form',
                ])
            !!}

            <input type="hidden" name="master_id" value="{{ $id }}">


            <div class="card-body">
                <div class="float-left">

                </div>
                <div class="float-right">
                    @if ($master_data->mef_process_status_id != 10)
                    <button type="submit" class="btn btn-primary">Publish</button>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>

            @include('Goals::goal_tracking_view')

            {!! form::close() !!}

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

@section('footer-script')

@endsection
