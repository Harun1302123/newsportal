@extends('frontend.layouts.master')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/password-strength/password_strength.css') }}">
    <style>
        .terms li {
            list-style: show;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <h2 class="text-center nfis-page-heading  mt-4">Verification Process</h2>
                    <div class="card-body">
                        @include('partials.messages')
                        <div class="col-md-12 col-sm-12">
                            {!! Form::open([
                                'url' => '/users/created-user-verification/' . $encrypted_token,
                                'method' => 'patch',
                                'class' => 'form-horizontal',
                                'id' => 'vreg_form',
                            ]) !!}
                            <div class="col-md-12 col-sm-12">
                                <h3 class=" nfis-sec-title">Terms & Conditions</h3>
                                <h4>Terms and conditions to use this system can be briefed as :</h4>
                                <ol class="terms mb-4">
                                    <li>You must follow any policies made available to you within the Services.</li>
                                    <li>You have to fill all the given fields with correct information and take
                                        responsibility if any wrong or misleading information has been given</li>
                                    <li>You are responsible for the activity that happens on or through your account. So,
                                        keep your password confidential.</li>
                                    <li>We may modify these terms or any additional terms that apply to a Service to, for
                                        example,
                                        reflect changes to the law or changes to our Services. You should look at the terms
                                        regularly.</li>
                                </ol>
                            </div>


                            <div class=" w-75 rounded mx-auto d-block">
                                <div class="card border-0 shadow bg-white rounded card-info">
                                    <h4 class="card-title text-center mt-2 nfis-sec-title">Set your password</h4>
                                    <div class="card-body">

                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="text-danger">{{ $error }}<br>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <div id="myPassword">
                                                    <div class="col-lg-12">
                                                        {!! Form::password(
                                                            'user_new_password',
                                                            $attributes = [
                                                                'class' => 'form-control required',
                                                                'minlength' => '6',
                                                                'placeholder' => 'Enter your new password',
                                                                'onkeyup' => 'enableSavePassBtn()',
                                                                'id' => 'user_new_password',
                                                                'data-rule-maxlength' => '120',
                                                            ],
                                                        ) !!}
                                                        <input type="text" class="form-control" id="enable_show"
                                                            style="display:none" />
                                                        {!! $errors->first('user_new_password', '<span class="help-block">:message</span>') !!}
                                                        {{-- <a href="" class="button_strength ">Show</a> --}}
                                                        <div class="strength_meter">
                                                            <div>
                                                                <p></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pswd_info">
                                                        <h4>Password must include:</h4>
                                                        <ul>
                                                            <li data-criterion="length" class="invalid">06-20<strong>
                                                                    Characters</strong></li>
                                                            <li data-criterion="capital" class="invalid">At least
                                                                <strong>one capital
                                                                    letter</strong></li>
                                                            <li data-criterion="number" class="invalid">At least <strong>one
                                                                    number</strong></li>
                                                            <li data-criterion="specialchar" class="invalid">At least
                                                                <strong>one
                                                                    special character</strong></li>
                                                            <li data-criterion="letter" class="valid">No spaces</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Confirm New
                                                password</label>
                                            <div class="col-sm-10">
                                                <div class="col-lg-12">
                                                    {!! Form::password(
                                                        'user_confirm_password',
                                                        $attributes = [
                                                            'class' => 'form-control required',
                                                            'minlength' => '6',
                                                            'placeholder' => 'Enter your new password',
                                                            'id' => 'user_confirm_password',
                                                            'data-rule-maxlength' => '120',
                                                        ],
                                                    ) !!}
                                                    <input type="text" class="form-control" style="display:none" />
                                                    {!! $errors->first('user_new_confirm_password', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <label>
                                                {!! Form::checkbox('user_agreement', 1, null, ['class' => 'required']) !!}
                                                &nbsp;
                                                I have read and agree to terms and conditions.
                                            </label>
                                        </div>

                                        <div class="col-lg-3 float-right pt-3">
                                            <button type="submit" class="btn btn-primary" disabled
                                                id="update_pass_btn"><b>Save and Continue</b></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>


                            <div class="form-group">
                            </div>
                            <div class="col-md-8"><br /></div>
                            <div class="form-group">
                                <div class="col-lg-3 mx-auto d-block">
                                    <p>Already have an account? <b>{!! link_to('users/login', 'Login', ['class' => '']) !!}</b></p>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {!! Form::close() !!}
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('assets/plugins/password-strength/password_strength.js') }}" type="text/javascript"></script>

    <script>
        // Show password validation check
        $(document).ready(function() {
            $("#enable_show").on("input", function() {
                var show_pass_value = document.getElementById('enable_show').value;
                checkRegularExp(show_pass_value);
            });
        });

        function enableSavePassBtn() {
            var password_input_value = document.getElementById('user_new_password').value;
            checkRegularExp(password_input_value);
        }

        function checkRegularExp(password) {
            var submitbtn = $('#update_pass_btn');
            var user_password = $('#user_new_password');
            var enable_show = $('#enable_show');
            var regularExp = /^(?!\S*\s)(?=.*\d)(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹])(?=.*[A-Z]).{6,20}$/;

            if (regularExp.test(password) == true) {
                user_password.removeClass('is-invalid');
                user_password.addClass('is-valid');
                enable_show.removeClass('is-invalid');
                submitbtn.prop("disabled", false);
                submitbtn.removeClass("disabled");
            } else {
                enable_show.addClass('is-invalid');
                user_password.addClass('is-invalid');
                submitbtn.prop("disabled", true);
                submitbtn.addClass("disabled");
            }

        }

        $(document).ready(function($) {
            $('#myPassword').strength_meter();
        });
        $('#myPassword').strength_meter({

            //  CSS selectors
            strengthWrapperClass: 'strength_wrapper',
            inputClass: 'strength_input',
            strengthMeterClass: 'strength_meter',
            toggleButtonClass: 'button_strength',

            // text for show / hide password links
            showPasswordText: 'Show Password',
            hidePasswordText: 'Hide Password'

        });


        $(function() {
            var _token = $('input[name="_token"]').val();
            $("#vreg_form").validate({
                rules: {
                    user_confirm_password: {
                        equalTo: "#user_new_password"
                    }
                },
                errorPlacement: function() {
                    return false;
                }
            });
        });
    </script>

    <style>
        input[type="checkbox"].error {
            outline: 1px solid red
        }
    </style>
@endsection
