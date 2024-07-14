@extends('layouts.admin')

@section('header-resources')
    @include('Users::partials.profile_info_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="card">
                    <div class="card-header card-outline card-primary">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_1" data-toggle="tab"> {!! trans('Users::messages.profile') !!} </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab_2" data-toggle="tab"><strong> {!! trans('Users::messages.change_password') !!}</strong></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab_4" data-toggle="tab" id="50Activities" aria-expanded="false"><b>{!! trans('Users::messages.last_50_activities') !!}</b></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab_5" data-toggle="tab" id="accessLog" aria-expanded="false"><b>{!! trans('Users::messages.access_log') !!}</b></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab_6" data-toggle="tab" id="accessLogFailed" aria-expanded="false"><b>{!! trans('Users::messages.access_log_failed') !!}</b></a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">

                        <!-- Tab panes -->
                        <div class="tab-content">

                            @include('Users::profile_info_update')

                            @include('Users::profile_password_change')

                            <div id="tab_4" class="container tab-pane fade">
                                <table id="last50activities"
                                       class="table table-striped table-bordered"
                                       width="100%" cellspacing="0" style="font-size: 14px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{!! trans('Users::messages.action_taken') !!}</th>
                                        <th>{!! trans('Users::messages.ip') !!}</th>
                                        <th>{!! trans('Users::messages.date_n_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div id="tab_5" class="container tab-pane fade">
                                <table id="accessList" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('Users::messages.remote_address') !!}</th>
                                        <th>{!! trans('Users::messages.login_type') !!}</th>
                                        <th>{!! trans('Users::messages.login_time') !!}</th>
                                        <th>{!! trans('Users::messages.logout_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div id="tab_6" class="container tab-pane fade">
                                <table id="accessLogFailedList" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('Users::messages.remote_address') !!}</th>
                                        <th>{!! trans('Users::messages.failed_login_time') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

@endsection


@section('footer-script')
    @include('Users::partials.profile_info_js')
@endsection
