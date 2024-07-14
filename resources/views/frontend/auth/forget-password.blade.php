@extends('frontend.layouts.master')

@section('style')
    <style>
        .form-group{
            margin-bottom: 0;
        }
        a:hover{
            text-decoration: none;
        }
        #btnSignIn{
            margin: 0 28px;
            width: 100%;
        }
    </style>
@endsection

@section ('content')
    <div class="row my-5">
        <div class="col-md-12">
            <div class="wrapper">
                <div class="container container-bg"><br>
                    <div class="offset-2 col-md-4 login-panel m-auto">

                        <div class="card card-info">
                            {!! Form::open(['url' => 'reset-forgotten-password','method' => 'post', 'class' =>'form-horizontal', 'id' => 'forgetPassword']) !!}

                            <div class="card-body">
                                <div class="form-group row">
                                    <p style="padding: 0 25px 10px; text-align: center; color: rgba(0,0,0,.7);">{{ languageStatus() == 'en' ? 'You forgot your password? Here you can easily retrieve a new password.' : "আপনি আপনার পাসওয়ার্ড ভুলে গেছেন? এখানে আপনি সহজেই একটি নতুন পাসওয়ার্ড পুনরুদ্ধার করতে পারবেন।" }}</p>
                                    @include('partials.messages')
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-3">
                                        {!! Form::text('username', '',['class' => 'form-control required','placeholder' => (languageStatus() == 'en') ? 'Email Address/ Username' : 'ইমেইল/ ইউজার নাম','id'=>'username']) !!}
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="text-danger error-msg"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row py-2">
                                <button type="submit" class="btn btn-primary float-right" id="btnSignIn">{{ languageStatus() == 'en' ? 'Request new password' : "নতুন পাসওয়ার্ডের জন্য আবেদন করুন" }}</button>

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const btnSubmit = document.querySelector('#btnSignIn');
        btnSubmit.addEventListener('click', function (e) {
            $("#forgetPassword").validate({
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
