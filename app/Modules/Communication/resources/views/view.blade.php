@php

    if (!$view_permission) {
        die('You have no access right! Please contact with system admin if you have any query.');
    }
@endphp
@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-eye"></i> View Communication </h3>
                </div>

                <!-- /.panel-heading -->

                <div class="card-body">
                    @if(in_array(auth()->user()->user_type, [1,15,2,4]))

                    <div class="form-group row">
                        <label for="" class="col-md-2 control-label">Communication Type :</label>
                        <div class="col-md-10">
                           {{ !empty($data->communication_type == 'organization') ? 'Organization' : 'Individual' }}
                        </div>
                    </div>

                    @if($data->communication_type == 'individual')
                        <div class="form-group row" id="user_list"
                             style="">
                            <label for="" class="col-md-2 control-label">User List: </label>
                            <div class="col-md-10">
                                @foreach($data->getUsers() as $user)
                                    {{ $user->user_first_name.' '.$user->user_middle_name.' '.$user->user_last_name .'('.$user->username.'-'.$user->user_email.'), ' }}
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="form-group row" id="organization_type">
                            <label for="" class="col-md-2 control-label"> Organization Type:</label>
                            <div class="col-md-10">
                                {{ $data->organization_type_text }}
                            </div>
                        </div>
                        @if($data->organization_type_text != 'All')


                        <div class="form-group row" id="organization_type">
                            <label for="" class="col-md-2 control-label"> Organization List:</label>
                            <div class="col-md-10">

                                @if(in_array("0", json_decode($data->organization_ids)))
                                    All
                                @else
                                    @foreach($data->getOrganizations() as $organization)
                                        {{ $organization->organization_name_en }} ,
                                    @endforeach
                                @endif


                            </div>
                        </div>
                        @endif
                    @endif

                    @endif



                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Title:</label>
                        <div class="col-md-10">
                            {{ $data->title }}
                        </div>
                    </div>

                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Description:</label>
                        <div class="col-md-10">
                            {{ $data->description }}
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Start Date:</label>
                        <div class="col-md-10">
                            {{ $data->start_date }}
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> End Date:</label>
                        <div class="col-md-10">
                            {{ $data->end_date }}
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Start Time:</label>
                        <div class="col-md-10">
                            {{ App\Libraries\CommonFunction::formatLastUpdatedTime($data->start_time) ? $data->start_time : '' }}
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> End Time:</label>
                        <div class="col-md-10">
                            {{ App\Libraries\CommonFunction::formatLastUpdatedTime($data->end_time) ? $data->end_time : '' }}
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Attachment:</label>
                        <div class="col-md-10">
                            @if($data->attachment)
                                <a href="/{{ $data->attachment }}" target="_blank" class="btn btn-primary "> <i class="fa fa-eye"></i> Open </a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row" id="organization_type">
                        <label for="" class="col-md-2 control-label"> Status:</label>
                        <div class="col-md-10">
                            {{ !empty($data->status == 1 ) ? 'Active' : 'Inactive' }}
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('communications.list')  }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                        </a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
