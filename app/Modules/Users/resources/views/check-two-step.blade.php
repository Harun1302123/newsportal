@extends('frontend.layouts.master')

@section('content')
  <div class="container my-5" >
        <div class="row mb-3">
            <div class="col-12 pt-4 pb-5 rounded" style="background: snow; opacity:0.88;">
                <h2 class="text-center pb-4 pt-2 nfis-sec-title">Verification Code </h2>

                {!! Form::open([
                    'url' => 'users/verify-two-step/',
                    'method' => 'patch',
                    'class' => 'form-horizontal',
                    'id' => 'verifyForm',
                ]) !!}

                @if (isset($req_dta))
                    {!! Form::hidden('req_dta', $req_dta) !!}
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow bg-white rounded">
                            <div class="card-body">
                                <input type="hidden" id="smsTrackingCode" value="-1">
                                <input type="hidden" id="OTPExpireTime" value="-1">

                                    @if ($steps == 'email')
                                        <img src="{{ url('images/email_icon.png') }}"  class="rounded mx-auto d-block"
                                            alt="Two-step verification by email" id="email_verification_img"
                                            width="80" /><br />
                                        An email has been sent to your given address
                                        (<?php echo substr($user_email, 0, 3) . '***************' . substr($user_email, -9); ?>).
                                    @else
                                        <img src="{{ url('images/sms.png') }}"  class="rounded mx-auto d-block"
                                            alt="Two-step verification by SMS" id="sms_verification_img" width="80" /><br />
                                        An SMS has been sent to your given mobile number
                                        (<?php echo substr($user_phone, 0, 6) . '************' . substr($user_phone, -2); ?>).
                                    @endif
                                    Please enter the 4 digit code that you have got.


                                <div class="col-md-12"><br></div>

                                <div class="col-md-7 ">
                                    <div class="form-group row ">
                                        {!! Form::text('security_code', '', [
                                            'class' => 'form-control required',
                                            'placeholder' => 'Enter your security code',
                                        ]) !!}
                                        {!! $errors->first('security_code', '<span class="help-block">:message</span>') !!}

                                    </div>
                                </div>
                                <a href="{{ url('/users/logout') }}" class="btn btn-danger mr-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                &nbsp; &nbsp; <b>or</b> &nbsp; &nbsp;
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-chevron-circle-right"></i>
                                    Submit
                                </button>
                            </div>

                          </div>
                        <!-- /.form end -->
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="col-md-12">
                            <h4 style="font-size: 22px;">What to do if you do not get the verification code?</h4>
                            <p style="line-height: 1.9;">
                                Mobile SMS and email are used to send the verification code to the system.
                               <br>
                               If you don't get the verification code, you can try alternative methods.
                            </p>

                        </div>
                        <div class="col-md-12 ">
                            <h4 style="font-size: 22px;">If multiple verification codes are received, which one will be accepted?</h4>
                            <p style="line-height: 1.9;">If you receive multiple verification codes from the system, the last one is sent
                                system will accept.</p>
                        </div>
                        {{-- <h4>ভেরিফিকেশন কোড না পেলে করণীয় কী?</h4>
                        <ul>
                            <li>সিস্টেমে ভেরিফিকেশন কোড প্রেরণের জন্য মোবাইলে এস.এম.এস এবং ইমেইল এই দুইটি মাধ্যম ব্যবহার করা
                                হয়। </li>
                            <li>ভেরিফিকেশন কোড না পেলে আপনি বিকল্প মাধ্যমটিতে চেষ্টা করতে পারেন।</li>
                        </ul>
                        <h4>একাধিক ভেরিফিকেশন কোড পেলে কোনটি গ্রহণযোগ্য হবে?</h4>
                        <ul>
                            <li>আপনি যদি সিস্টেম থেকে একাধিক ভেরিফিকেশন কোড পেয়ে থাকেন, তাহলে সর্বশেষে প্রেরিত কোডটিই
                                সিস্টেম গ্রহণ করবে। </li>
                        </ul> --}}
                    </div>
                </div>

                {!! Form::close() !!}<!-- /.form end -->
            </div>
        </div>
    @endsection

    @section('footer-script')
          <script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
        <script>
            $(document).ready(
                function() {
                    $("#verifyForm").validate({
                        errorPlacement: function() {
                            return false;
                        }
                    });
                });
        </script>
        <style>
            ul li {
                list-style-type: none;
            }
        </style>
    @endsection
