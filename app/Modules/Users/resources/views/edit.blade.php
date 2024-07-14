@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset("assets/plugins/select2/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/plugins/intlTelInput/css/intlTelInput.min.css") }}"/>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong><i class="fa fa-user" aria-hidden="true"></i> {{trans('Users::messages.user_edit_form_title')}}</strong></h5>
                </div>
                {!! Form::open(array('url' => '/users/update/'.App\Libraries\Encryption::encodeId($users->id),'method' => 'post', 'class' => 'form-horizontal',
                        'id'=> 'user_edit_form')) !!}

                {!! Form::hidden('selected_file', '', array('id' => 'selected_file')) !!}
                {!! Form::hidden('validateFieldName', '', array('id' => 'validateFieldName')) !!}
                {!! Form::hidden('isRequired', '', array('id' => 'isRequired')) !!}
                {!! Form::hidden('isRequired', '', array('id' => 'isRequired')) !!}
                {!! Form::hidden('identity_type', 'nid') !!}

                <div class="card-body">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 required-star">User's full name</label>
                                <div class="col-md-8">
                                    <div class="input-group ">
                                        {!! Form::text('name_eng', $users->name_eng, $attributes = ['class' => 'form-control required', 'placeholder' => "Enter user's full name"]) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                    {!! $errors->first('name_eng', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                {!! Form::label('user_gender', trans('Users::messages.user_gender'), ['class' => 'text-left required-star col-md-4', 'id' => 'user_gender']) !!}
                                <div class="col-sm-8">
                                    <label class="identity_hover">
                                        {!! Form::radio('user_gender', '1', $users->gender_id == 1 ? true : false, ['class' => 'required', 'id' => 'user_gender_male']) !!}
                                        Male
                                    </label>
                                    &nbsp;&nbsp;
                                    <label class="identity_hover">
                                        {!! Form::radio('user_gender', '2', $users->gender_id == 2 ? true : false, ['class' => 'required', 'id' => 'user_gender_female']) !!}
                                        Female
                                    </label>
                                    &nbsp;&nbsp;
                                    <label class="identity_hover">
                                        {!! Form::radio('user_gender', '3', $users->gender_id == 3 ? true : false, ['class' => 'required', 'id' => 'user_gender_other']) !!}
                                        Other
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 required-star">{{ trans('Users::messages.user_mobile') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        {!! Form::text('user_mobile', $users->user_mobile, $attributes = ['class' => 'form-control required bd_mobile', 'placeholder' => 'Enter your Number', 'id' => 'user_mobile', 'disabled'=>'true']) !!}
                                    </div>
                                    {!! $errors->first('user_mobile', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 required-star">User's unique name</label>
                                <div class="col-md-8">
                                    <div class="input-group ">
                                        {!! Form::text('username', $users->username, $attributes = ['class' => 'form-control required', 'placeholder' => 'Enter user name', 'id' => 'username', 'disabled'=>'disabled']) !!}
                                        <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                    {!! $errors->first('username', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label
                                    class="col-md-4 required-star">{{ trans('Users::messages.user_type') }}</label>
                                <div class="col-md-8">
                                    {!! Form::select('user_type', $user_types, $users->user_type, $attributes = ['class' => 'form-control required', 'data-rule-maxlength' => '40', 'placeholder' => 'Select One', 'id' => 'user_type']) !!}
                                    {!! $errors->first('user_type', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div
                                class="form-group row has-feedback {{ $errors->has('user_email') ? 'needs-validation' : '' }}">
                                <label class="col-md-4 required-star">{{ trans('Users::messages.user_email') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group ">
                                        {!! Form::text('user_email', $users->user_email, $attributes = ['class' => 'form-control email required', 'data-rule-maxlength' => '40', 'placeholder' => 'Enter your Email Address', 'id' => 'user_email', 'disabled'=>'disabled']) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="fa fa-envelope"></i></span>
                                        </div>
                                    </div>
                                    {!! $errors->first('user_email', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label
                                    class="col-md-4 required-star">User Role:</label>
                                <div class="col-md-8">
                                    {!! Form::select('user_role_id', $user_roles, $users->user_role_id, $attributes = ['class' => 'form-control required', 'placeholder' => 'Select One', 'id' => 'user_role_id']) !!}
                                    {!! $errors->first('user_role_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row has-feedback">

                                <div style="margin-left: 10px" class="card card-default" id="browseimagepp">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 addImages" style="max-height:300px;">
                                            <label class="center-block image-upload" for="user_pic" style="margin: 0px">
                                                <figure>
                                                    <img
                                                        src="{{ !empty($users->user_pic) ? url($users->user_pic) : url('images/photo_default.png') }}"

                                                        class="img-responsive img-thumbnail" id="user_pic_preview">
                                                </figure>
                                                <input type="hidden" id="user_pic_base64" name="user_pic_base64"
                                                       value="">
                                                @if(!empty($users->user_pic))
                                                    <input type="hidden" name="user_pic"
                                                           value="{{$users->user_pic}}"/>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <h4 id="profile_image">
                                                <label for="user_pic" class="text-left required-star">Profile
                                                    image</label>
                                            </h4>
                                            <span class="text-success col-lg-8 text-left"
                                                  style="font-size: 9px; font-weight: bold; display: block;">[File Format: *.jpg/ .jpeg/ .png | Width 300PX, Height 300PX]</span>

                                            <span id="user_err" class="text-danger col-lg-8 text-left"
                                                  style="font-size: 10px;"> </span>
                                            <div class="clearfix"><br></div>
                                            <label class="btn btn-primary btn-file">
                                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                Browse<input type="file" class="custom-file-input input-sm "
                                                             name="user_pic" id="user_pic"
                                                             onchange="imageUploadWithCroppingAndDetect(this, 'user_pic_preview', 'user_pic_base64')"
                                                             size="300x300">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="pull-left">
                    </div>
                    <div class="float-right">
                        <a href="/users/lists" class="btn btn-default "><i class="fa fa-times"></i><b>
                                Close</b></a>
                        @if($edit_permission)
                            <button type="submit" class="btn  btn-primary" id='submit_btn' onclick="this.disabled=true;this.value='Sending';this.form.submit();"><b>Save</b>
                            </button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection


@section('footer-script')
    @include('Users::partials.profile_edit_js')
@endsection <!--- footer-script--->
