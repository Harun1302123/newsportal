@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row"> <!-- Horizontal Form -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>{{ trans('Users::messages.user_profile') }}</strong></h5>
                </div> <!-- /.panel-heading -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.user_name') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{!! $user->username ?? null !!}</span>
                            </div>

                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.user_type') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->type_name }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">User's role</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->userRole->role_name }}</span>
                            </div>
                            @if ($user->organizationType->org_type_short_name)
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">User's Organization Type</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->organizationType->org_type_short_name }}</span>
                            </div>
                            @endif

                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.user_mobile') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->user_mobile }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.user_email') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->user_email }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.user_status') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span
                                    class="col-md-5 col-xs-6">{{ $user->user_status == 1 ? 'Active' : 'Inactive' }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">{{ trans('Users::messages.verification_status') }}</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->is_email_verified == 1 ? 'Yes' : 'No' }}</span>
                                @if ($user->is_email_verified == 0)
                                    <a
                                        href="{{ url('users/resend-email-verification-from-admin/' . Encryption::encodeId($user->id)) }}">
                                        <button type="button" class="btn btn-info">Resend mail</button>
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-10 col-xs-12">
                                @if ($user->is_approved != 1)
                                    <label class="col-md-4 text-left">{{ trans('Users::messages.verification_expire') }}
                                        : </label>
                                    <span class="col-md-1 col-xs-1">:</span>
                                    <span class="col-md-8 text-left">{!! $user->user_hash_expire_time !!}&nbsp;</span>
                                @endif
                            </div>
                            <?php
                            $approval = '';

                            if ($user->user_status == 0) {
                                // $approval = ' <a data-toggle="modal" data-target="#myModal2" class="btn btn-sm btn-danger addProjectModa2"><i class="fa fa-times"></i>&nbsp;Reject User</a> ';
                            }
                            ?>
                        </div>

                        <div class="col-md-3 text-center">
                            <br />
                            <img src="{{ asset($user->user_pic) }}"
                                onerror="this.src=`{{ asset('/images/default_profile.jpg') }}`"
                                alt="Profile picture" class="profile-user-img img-responsive img-circle" />
                        </div>
                    </div>
                </div><!-- /.box -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ url('users/list') }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Close</a>
                    </div>
                    <div class="float-right">
                        <?php
                        $edit = '';
                        $activate = '';
                        $reset_password = '';
                        
                        if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 2)) {
                            $reset_password = '<a href="' . url('users/reset-password/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-warning"' . 'onclick="return confirm(\'Are you sure?\')">' . '<i class="fa fa-refresh"></i> Reset password</a>';
                            $edit = '<a href="' . url('users/edit/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                            if ($user->user_status == 0) {
                                $activate = '<a href="' . url('users/activate/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-success"><i class="fa fa-unlock"></i>  Activate</a>';
                            } else {
                                $activate = '<a href="' . url('users/activate/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-danger"' . 'onclick="return confirm(\'Are you sure?\')">' . '<i class="fa fa-unlock-alt"></i> Deactivate</a>';
                            }
                        }
                        if ($user->is_approved == 1) {
                            if ($edit_permission) {
                                echo '&nbsp;' . $edit;
                                echo '&nbsp;' . $activate;
                            }
                        } else {
                            echo $approval;
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection <!--content section-->
