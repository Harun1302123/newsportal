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
                    <h5 class="card-title"><strong>{{ trans('Users::messages.user_profile') }}</strong></h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Central Email Address</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->central_email??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Phone Number</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->phone_number??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Organization Name</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{  $user->organization->organization_name_en??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Organization Type</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->organizationType->organization_type??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Preferred User ID</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->user_id??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Focal Point Name</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->fp_name??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Focal Point Designation</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->fp_designation??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Focal Phone Number</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->fp_phone_number	??null }}</span>
                            </div>     
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Focal Point Email</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->fp_email??null }}</span>
                            </div>     
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Deputy Focal Point Name</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->dfp_name??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Deputy Focal Point Designation</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->dfp_designation??null }}</span>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Deputy Focal Phone Number</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->dfp_phone_number	??null }}</span>
                            </div>     
                            <div class="col-md-10 col-xs-12">
                                <label class="col-md-4 col-xs-5">Deputy Focal Point Email</label>
                                <span class="col-md-1 col-xs-1">:</span>
                                <span class="col-md-5 col-xs-6">{{ $user->dfp_email??null }}</span>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('signup.list') }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Close</a>
                    </div>
                    <div class="float-right">
                        @php
                            if ($user->status == 0){
                                $create_user_btn = '<a href="' . route('signup.create_user', ['id' => Encryption::encodeId($user->id)]) . '" class="btn btn-flat btn-success m-1"><i class="fa fa-folder-open-o"></i> Approve </a>';
                                // echo $create_user_btn;
                                $reject_user_btn = '<a href="' . route('signup.reject_user', ['id' => Encryption::encodeId($user->id)]) . '" class="btn btn-flat btn-danger m-1"><i class="fa fa-times"></i> Reject </a>';
                                echo $create_user_btn . $reject_user_btn;  
                            }
                        @endphp

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection <!--content section-->
