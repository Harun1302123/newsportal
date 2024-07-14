@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset('plugins/intlTelInput/css/intlTelInput.min.css') }}"/>
    <style>
        .hidden{
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-outline card-primary bg-cyan">
                    <h5><strong><i class="fa fa-user-plus" aria-hidden="true"></i>
                            {{ trans('Users::messages.new_user_form_title') }}</strong>
                    </h5>
                </div>

                {!! Form::open(['url' => '/users/store-new-user', 'method' => 'patch', 'class' => 'form-horizontal', 'id' => 'create_user_form', 'enctype' => 'multipart/form-data', 'files' => 'true']) !!}
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @if (!$organization_id)
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 required-star">User's full name</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {!! Form::text('name_eng', old('name_eng'), $attributes = ['class' => 'form-control required', 'placeholder' => "Enter user's full name"]) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="fa fa-user"></i></span>
                                            </div>
                                        </div>
                                        {!! $errors->first('name_eng', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if ($organization_id)
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 required-star">First Name</label>
                                        <div class="col-md-8">
                                            <div class="input-group ">
                                                {!! Form::text('user_first_name', old('user_first_name'), $attributes = ['class' => 'form-control required', 'placeholder' => "First Name"]) !!}
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"><i
                                                            class="fa fa-user"></i></span>
                                                </div>
                                            </div>
                                            {!! $errors->first('user_first_name', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 required-star">Last Name</label>
                                        <div class="col-md-8">
                                            <div class="input-group ">
                                                {!! Form::text('user_last_name', old('user_last_name'), $attributes = ['class' => 'form-control required', 'placeholder' => "Last Name"]) !!}
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-user"></i></span>
                                                </div>
                                            </div>
                                            {!! $errors->first('user_last_name', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 required-star">Position/Title</label>
                                        <div class="col-md-8">
                                            <div class="input-group ">
                                                {!! Form::text('user_designation', old('user_designation'), $attributes = ['class' => 'form-control required', 'placeholder' => "Position/Title"]) !!}
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-user"></i></span>
                                                </div>
                                            </div>
                                            {!! $errors->first('user_designation', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group row">
                                    {!! Form::label('user_gender', trans('Users::messages.user_gender'), ['class' => 'text-left required-star col-md-4', 'id' => 'user_gender']) !!}
                                    <div class="col-sm-8">
                                        <label class="identity_hover">
                                            {!! Form::radio('user_gender', '1', false, ['class' => 'required', 'id' => 'user_gender_male']) !!}
                                            Male
                                        </label>
                                        &nbsp;&nbsp;
                                        <label class="identity_hover">
                                            {!! Form::radio('user_gender', '2', false, ['class' => 'required', 'id' => 'user_gender_female']) !!}
                                            Female
                                        </label>
                                        &nbsp;&nbsp;
                                        <label class="identity_hover">
                                            {!! Form::radio('user_gender', '3', false, ['class' => 'required', 'id' => 'user_gender_other']) !!}
                                            Other
                                        </label>
                                    </div>
                                    {!! $errors->first('user_gender', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 required-star">{{ trans('Users::messages.user_mobile') }}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {!! Form::text('user_mobile', old('user_mobile'), $attributes = ['class' => 'form-control required bd_mobile', 'maxlength' => "10", 'placeholder' => 'Enter your Number', 'id' => 'user_mobile']) !!}
                                        </div>
                                        {!! $errors->first('user_mobile', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 required-star">User's name(for login)</label>
                                    <div class="col-md-8">
                                        <div class="input-group ">
                                            {!! Form::text('username', old('username'), $attributes = ['class' => 'form-control required', 'placeholder' => 'Enter user name', 'id' => 'username']) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="fa fa-user"></i></span>
                                            </div>
                                        </div>
                                        {!! $errors->first('username', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>

                            @if (!$organization_id)
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label
                                            class="col-md-4 required-star">{{ trans('Users::messages.user_type') }}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('user_type', $user_types, old('user_type'), $attributes = ['class' => 'form-control required', 'data-rule-maxlength' => '40', 'placeholder' => 'Select One', 'id' => 'user_type']) !!}
                                            {!! $errors->first('user_type', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group row has-feedback {{ $errors->has('user_email') ? 'needs-validation' : '' }}">
                                    <label class="col-md-4 required-star">{{ trans('Users::messages.user_email') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group ">
                                            {!! Form::text('user_email', old('user_email'), $attributes = ['class' => 'form-control email required', 'data-rule-maxlength' => '40', 'placeholder' => 'Enter your Email Address', 'id' => 'user_email']) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="fa fa-envelope"></i></span>
                                            </div>
                                        </div>
                                        {!! $errors->first('user_email', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 hidden" id="user_role_div">
                                <div class="form-group row">
                                    <label
                                        class="col-md-4 required-star">User Role:</label>
                                    <div class="col-md-8">
                                        {!! Form::select('user_role_id', $user_roles, old('user_role_id'), $attributes = ['class' => 'form-control required', 'placeholder' => 'Select One', 'id' => 'user_role_id']) !!}
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
                                                            src="{{ url('images/photo_default.png') }}"

                                                            class="img-responsive img-thumbnail" id="user_pic_preview">
                                                    </figure>
                                                    <input type="hidden" id="user_pic_base64" name="user_pic_base64"
                                                           value="">
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
                        </div> {{-- row --}}
                    </div>

                    <div class="card-footer">
                        <div class="float-left">
                            <a href="{{ url('users/list') }}" class="btn btn-default btn-sm"><i class="fa fa-times"></i>
                                <b>Close</b></a>
                        </div>
                        <div class="float-right">
                            @if ($add_permission)
                                <button type="submit" class="btn btn-block btn-sm btn-primary" id="submit"><b>Submit</b>
                                </button>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!--/panel-body-->
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset("plugins/intlTelInput/js/intlTelInput.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("plugins/intlTelInput/js/utils.js") }}" type="text/javascript"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>


    @include('partials.image-upload')

    <script>
        $(function () {
            $("#create_user_form").validate({
                errorPlacement: function () {
                    return true;
                }
            });
            $(".select2").select2();
        });
        $("#user_mobile").intlTelInput({
            hiddenInput: "user_mobile",
            onlyCountries: ["bd"],
            initialCountry: "BD",
            placeholderNumberType: "MOBILE",
            separateDialCode: true,
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function () {
            var _token = $('input[name="_token"]').val();
            $("#create_user_form").validate({
                errorPlacement: function () {
                    return false;
                },
                submitHandler: function (form) { // <- pass 'form' argument in
                    $("#submit").attr("disabled", true);
                    form.submit(); // <- use 'form' argument here.
                }
            });
        })

        // remove laravel error message start
        @if ($errors->any()) $('form input[type=text]').on('keyup', function (e) {
            if ($(this).val() && e.which != 32) {

                if ($(this).parent().parent().hasClass('has-error')) {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).siblings(".help-block").hide();
                } else {
                    $(this).parent().parent().parent().removeClass('has-error');
                    $(this).parent().siblings(".help-block").hide();
                }

            }
        });

        $('form select').on('change', function (e) {
            if ($(this).val()) {
                $(this).siblings(".help-block").hide();
                $(this).parent().parent().removeClass('has-error');
            }
        }); @endif
        // remove laravel error message end


        /**
         * Convert an image to a base64 url
         * @param  {String}   url
         * @param  {String}   [outputFormat=image/png]
         */
        function convertImageToBase64(img, outputFormat) {
            var originalWidth = img.style.width;
            var originalHeight = img.style.height;

            img.style.width = "auto";
            img.style.height = "auto";
            img.crossOrigin = "Anonymous";

            var canvas = document.createElement("canvas");

            canvas.width = img.width;
            canvas.height = img.height;

            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

            img.style.width = originalWidth;
            img.style.height = originalHeight;

            // Get the data-URL formatted image
            // Firefox supports PNG and JPEG. You could check img.src to
            // guess the original format, but be aware the using "image/jpg"
            // will re-encode the image.
            var dataUrl = canvas.toDataURL(outputFormat);

            //return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
            return dataUrl;
        }

        function convertImageUrlToBase64(url, callback, outputFormat) {
            var img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = function () {
                callback(convertImageToBase64(this, outputFormat));
            };
            img.src = url;
        }


        // Convert NID image URL to base64 format
        var user_image = $("#user_pic_preview").attr('src');
        convertImageUrlToBase64(user_image, function (url) {
            $("#user_pic_base64").val(url);
        });

        $(document).ready(function (){
            $('#user_type').trigger('change');
            $('#user_type').on('change', function (){
                if($(this).val() == 3){
                    $('#user_role_div').removeClass('hidden');
                    $('#user_role_id option').filter('[value="5"],[value="6"]').remove();
                }else if($(this).val() == 4){
                    $('#user_role_div').removeClass('hidden');
                    $('#user_role_id option').filter('[value="5"],[value="6"]').remove();
                }else {
                    $('#user_role_div').addClass('hidden');
                }
            });

            @if ($organization_id)
                $('#user_role_div').removeClass('hidden');
            @endif
            
        })
    </script>
@endsection
