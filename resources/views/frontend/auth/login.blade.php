@extends('frontend.layouts.master')

@section('content')

    <main class="site-main-content page-height">
        <div class="container">
            <div class="nfis-login-content">
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="nfis-login-container">
                            <div class="login-banner">
                                <img src="{{ asset('images/login/login-banner-img.jpg') }}" alt="Banner">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="nfis-login-container">
                            <div class="nfis-login-box">
                                <div class="form-block-item text-center">
                                    <h3>{{ languageStatus() == 'en' ? 'Login' : "লগইন" }}</h3>
                                </div>
                                @include('partials.messages')
                                <div class="form-block-item">
                                    <form action="" name="nfis_login_form">
                                        <div class="form-group">
                                            <label for="username">{{ languageStatus() == 'en' ? 'Email Address/ Username' : "ইমেইল/ ইউজার নাম" }}</label>
                                            <input type="email" class="form-control required" id="username" name="username" placeholder="{{ languageStatus() == 'en' ? 'Email Address/ Username' : "ইমেইল/ ইউজার নাম" }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{ languageStatus() == 'en' ? 'Password' : "পাসওয়ার্ড" }}</label>
                                            <div class="input-icon-right">
                                                <input id="password" type="password" class="form-control required" id="password" name="password" placeholder="{{ languageStatus() == 'en' ? 'Password' : "পাসওয়ার্ড" }}">
                                                <span onclick="showhide()" class="input-icon icon-password-eye"></span>
                                                <a class="forget-password-text" href="{{ url('forget-password') }}">{{ languageStatus() == 'en' ? ' Forgot Password?' : "পাসওয়ার্ড ভুলে গেছেন?" }}</a>
                                            </div>
                                        </div>

                                        <button type="submit" class="nfis-btn btn" id="btnSignIn" onclick="checkUserInformation('loginForm')">{{ languageStatus() == 'en' ? 'Login' : "লগইন" }}</button>
                                    </form>
                                </div>

                                {{-- <div class="form-block-item">
                                    <div class="text-center pt-4">
                                        <p>{{ languageStatus() == 'en' ? 'New to Reg?' : " নতুন রেজিষ্ট্রেশন?" }} <a href="{{ route("signup") }}">{{ languageStatus() == 'en' ? 'User Registration' : "ইউজার রেজিষ্ট্রেশন" }}</a></p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
    <script>
        const base_url = "{{ url('/') }}";
        const errorMsg = $('.error-msg');
        const captchaDiv = $('#captchaDiv');

        $(document).bind('keypress', function (e) {
            if (e.keyCode == 13) {
                checkUserInformation()
            }
        });

        function checkUserInformation() {
            if ($("#username").val() == '' || $("#passowrd").val() == '') {
                errorMsg.html("Please enter your username and password properly!");
                return false;
            }

            $("#btnSignIn").prop('disabled', true); // disable button
            $("#btnSignIn").html('<i class="fa fa-cog fa-spin"></i> Loading...');
            errorMsg.html("");
            $.ajax({
                url: '/login/check',
                type: 'POST',
                data: {
                    username: $('input[name="username"]').val(),
                    password: $('input[name="password"]').val(),
                    g_recaptcha_response: $('#g-recaptcha-response').val(),
                    _token: $('input[name="_token"]').val()
                },
                datatype: 'json',
                success: function (response) {
                    console.log(response);
                    if (response) {
                        window.location = base_url + response.redirect_to;
                    } else {
                        // if (response.hit >= 3) {
                        //     captchaDiv.css('display', 'block');
                        //     grecaptcha.reset();
                        // }
                        errorMsg.html(response.msg);
                    }
                    $("#btnSignIn").prop('disabled', false); // disable button
                    $("#btnSignIn").html('Sign In');
                },
                error: function (jqHR, textStatus, errorThrown) {
                    // Reset error message div and put the message inside
                    errorMsg.html(jqHR.responseJSON.message);
                    // console.log(jqHR.responseJSON.message)
                    console.log(jqHR, textStatus, errorThrown);
                    $("#btnSignIn").prop('disabled', false); // disable button
                    $("#btnSignIn").html('Sign In');
                }
            });
        }


        $('.onlyNumber').on('keydown', function (e) {
            //period decimal
            if ((e.which >= 48 && e.which <= 57)
                //numpad decimal
                || (e.which >= 96 && e.which <= 105)
                // Allow: backspace, delete, tab, escape, enter and .
                || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
                // Allow: Ctrl+A
                || (e.keyCode == 65 && e.ctrlKey === true)
                // Allow: Ctrl+C
                || (e.keyCode == 67 && e.ctrlKey === true)
                // Allow: Ctrl+V
                || (e.keyCode == 86 && e.ctrlKey === true)
                // Allow: Ctrl+X
                || (e.keyCode == 88 && e.ctrlKey === true)
                // Allow: home, end, left, right
                || (e.keyCode >= 35 && e.keyCode <= 39)) {

                var thisVal = $(this).val();
                if (thisVal.indexOf(".") != -1 && e.key == '.') {
                    return false;
                }
                $(this).removeClass('error');
                return true;
            } else {
                $(this).addClass('error');
                return false;
            }
        }).on('paste', function (e) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^0-9]/g, ''));
            }, 4);
        }).on('keyup', function (e) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^0-9]/g, ''));
            }, 4);
        });
        $(document).on('keypress', function (e) {
            if ($('#otp_step_1').is(':visible')) {
                var key = e.which;
                if (key == 13) { //This is an ENTER
                    $('#otpnext1').click();
                }
            }
        });
        $(document).on('keypress', function (e) {
            if ($('#otp_step_2').is(':visible')) {
                var key = e.which;
                if (key == 13) { //This is an ENTER
                    $('#otpnext3').click();
                }
            }
        });

        var timerCounter;
        var seconds = 180; //**change 180 for any number you want, it's the seconds **//
        function secondPassed() {

            $('#resend_link').css("display", "none");
            var minutes = Math.round((seconds - 30) / 60);
            var remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }

            document.getElementById('show_cowndown').innerHTML = minutes + ":" + remainingSeconds;
            if (seconds == 0) {
                clearInterval(timerCounter);
                document.getElementById('show_cowndown').innerHTML = "Expired!";

                $(".success-message-message-login").hide();
                $(".error-message-message-login").hide();
                $('#display_before').css("display", "none");
                $('#resend_link').css("display", "block");

            } else {
                seconds--;
            }

        }


        function checksmsStatus(email_id, expiredtime = null) {
            var currenttime = new Date();
            var currenttimemilisecond = currenttime.getTime();
            var after10 = (currenttimemilisecond + (10 * 1000));
            var after20 = (currenttimemilisecond + (20 * 1000));
            var expiredtimemilisecond = new Date(expiredtime).getTime();

            var x = setInterval(function () {
                var currenttime2 = new Date().getTime();
                $.ajax({
                    url: '/login/check-sms-send-status',
                    type: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        'email_id': email_id,
                    },
                    success: function (response) {

                        if (response.responseCode == 1) {
                            if (response.sms_status == 1) {
                                clearInterval(x);
                                $('#loading_send_sms').css("display", "none");
                                $(".error-message-message-login").hide();
                                $('.success-message-message-login').show().text(response.msg).delay(5000).fadeOut(300);
                                setTimeout("$('#display_before').css('display', 'block')", 5000);
                                $('#otp_step_1').css("display", "none");
                                $('#otpnext1').css("display", "none");
                                remainingtime(expiredtime);
                            } else {
                                if (currenttime2 > expiredtimemilisecond) {
                                    clearInterval(x);
                                    $('#loading_send_sms').html('Please Try after some times');
                                } else if (currenttime2 > after20) {
                                    $('#loading_send_sms').html('Please wait, sending SMS <i class="fa fa-spinner fa-spin"></i>');
                                } else if (currenttime2 > after10) {
                                    $('#loading_send_sms').html('Sending SMS <i class="fa fa-spinner fa-spin"></i>');
                                }


                            }
                        } else {
                            clearInterval(x);
                            $('#loading_send_sms').html('Please Try after some times');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    },
                    beforeSend: function (xhr) {
                        console.log('before send');
                    },
                    complete: function () {
                        //completed
                        timerCounter = setInterval('secondPassed()', 1000);
                    }
                });

            }, 2000);
        }

        function showhide() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

    </script>
@endsection
