@extends('frontend.layouts.master')
@section('content')

    <main class="site-main-content page-height">
        <div class="container">
            <div class="nfis-breadcrumb">
                <ul class="nfis-breadcrumb-lists">
                    <li class="nfis-bc-item bc-back-btn">
                        <a href="{{ route('frontend.home') }}">
                            <span class="bc-back-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                    <path opacity="0.4" d="M6.59015 11.3925C3.46604 11.3925 0.925408 8.85126 0.925408 5.72773C0.925408 2.60419 3.46604 0.0629883 6.59015 0.0629883C9.71368 0.0629883 12.2549 2.60419 12.2549 5.72773C12.2549 8.85126 9.71368 11.3925 6.59015 11.3925" fill="white"></path>
                                    <path d="M7.40704 8.11853C7.29884 8.11853 7.19008 8.07718 7.10738 7.99448L5.13208 6.02881C5.05221 5.94894 5.00746 5.84074 5.00746 5.72745C5.00746 5.61472 5.05221 5.50652 5.13208 5.42665L7.10738 3.45985C7.27335 3.29444 7.54186 3.29444 7.70784 3.46099C7.87325 3.62753 7.87268 3.89661 7.70671 4.06202L6.03391 5.72745L7.70671 7.39288C7.87268 7.55829 7.87325 7.8268 7.70784 7.99334C7.62513 8.07718 7.5158 8.11853 7.40704 8.11853" fill="white"></path>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Comment' : "মন্তব্য" }}</li>
                </ul>
            </div>
            @include('partials.messages')
            <div class="nfis-content-container mt-4">
                {!! Form::open(['route' => 'frontend.comments.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}
                <div class="nfis-login-content signup-box">
                    <div class="form-block-item text-center">
                        <h3>{{ languageStatus() == 'en' ? 'Comment' : "মন্তব্য" }}</h3>
                    </div>
                    <div class="form-block-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('name',languageStatus() == 'en' ? 'Name :' : "নাম :",['class'=>'col-md-12 required-star']) !!}
                                        <div class="col-md-12">
                                            {!! Form::text('name', old('name'), ['class' => 'form-control required']) !!}
                                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('email',languageStatus() == 'en' ? 'Email :' : "ইমেইল :",['class'=>'col-md-12 required-star']) !!}
                                        <div class="col-md-12">
                                            {!! Form::email('email', old('email'), ['class' => 'form-control required']) !!}
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group {{$errors->has('number') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('number',languageStatus() == 'en' ? 'Number :' : "নম্বর :",['class'=>'col-md-12']) !!}
                                        <div class="col-md-12">
                                            {!! Form::number('number', old('number'), ['class' => 'form-control']) !!}
                                            {!! $errors->first('number', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group {{$errors->has('details') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('details',languageStatus() == 'en' ? 'Details :' : "বিস্তারিত :",['class'=>'col-md-12 ']) !!}
                                        <div class="col-md-12">
                                            {!! Form::textarea('details', old('details'), ['placeholder' => languageStatus() == 'en' ? 'write your content here...' : "এখানে আপনার বিষয়বস্তু লিখুন...", 'class' => 'form-control details', 'size' => '5x3']) !!}
                                            {!! $errors->first('details','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="form-block-item">
                        <div class="flex-center px-4 pb-3">
                            <button type="submit" class="nfis-btn btn">{{ languageStatus() == 'en' ? 'Submit' : "সাবমিট" }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </main>
    {{--    <div class="main-page-content">--}}
    {{--        <div class="container">--}}
    {{--            <div class="nfis-breadcrumb">--}}
    {{--                <ul class="nfis-breadcrumb-lists">--}}
    {{--                <li class="nfis-bc-item bc-back-btn">--}}
    {{--                    <a href="{{ route('frontend.home') }}">--}}
    {{--                            <span class="bc-back-icon">--}}
    {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"--}}
    {{--                                     fill="none">--}}
    {{--                                    <path opacity="0.4"--}}
    {{--                                          d="M6.59015 11.3925C3.46604 11.3925 0.925408 8.85126 0.925408 5.72773C0.925408 2.60419 3.46604 0.0629883 6.59015 0.0629883C9.71368 0.0629883 12.2549 2.60419 12.2549 5.72773C12.2549 8.85126 9.71368 11.3925 6.59015 11.3925"--}}
    {{--                                          fill="white"></path>--}}
    {{--                                    <path--}}
    {{--                                        d="M7.40704 8.11853C7.29884 8.11853 7.19008 8.07718 7.10738 7.99448L5.13208 6.02881C5.05221 5.94894 5.00746 5.84074 5.00746 5.72745C5.00746 5.61472 5.05221 5.50652 5.13208 5.42665L7.10738 3.45985C7.27335 3.29444 7.54186 3.29444 7.70784 3.46099C7.87325 3.62753 7.87268 3.89661 7.70671 4.06202L6.03391 5.72745L7.70671 7.39288C7.87268 7.55829 7.87325 7.8268 7.70784 7.99334C7.62513 8.07718 7.5158 8.11853 7.40704 8.11853"--}}
    {{--                                        fill="white"></path>--}}
    {{--                                </svg>--}}
    {{--                            </span>--}}
    {{--                    </a>--}}
    {{--                </li>--}}
    {{--                <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>--}}

    {{--                <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Comment' : "মন্তব্য" }}</li>--}}
    {{--            </ul>--}}
    {{--            </div>--}}
    {{--            <div class="nfis-page-heading">--}}
    {{--                <h2>--}}
    {{--                    {{ languageStatus() == 'en' ? 'Comment' : "মন্তব্য" }}--}}
    {{--                </h2>--}}
    {{--            </div>--}}

    {{--            <div class="comment pb-4">--}}

    {{--                @include('partials.messages')--}}

    {{--                <div class="card card-outline card-primary">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h3 class="card-title"> </h3>--}}
    {{--                    </div>--}}

    {{--                    {!! Form::open(['route' => 'frontend.comments.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}--}}

    {{--                    <div class="card-body">--}}
    {{--                        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">--}}
    {{--                            <div class="row">--}}
    {{--                                {!! Form::label('name',languageStatus() == 'en' ? 'Name :' : "নাম",['class'=>'col-md-2 required-star']) !!}--}}
    {{--                                <div class="col-md-10">--}}
    {{--                                    {!! Form::text('name', old('name'), ['class' => 'form-control required']) !!}--}}
    {{--                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">--}}
    {{--                            <div class="row">--}}
    {{--                                {!! Form::label('email',languageStatus() == 'en' ? 'Email' : "ইমেইল",['class'=>'col-md-2 required-star']) !!}--}}
    {{--                                <div class="col-md-10">--}}
    {{--                                    {!! Form::email('email', old('email'), ['class' => 'form-control required']) !!}--}}
    {{--                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">--}}
    {{--                            <div class="row">--}}
    {{--                                {!! Form::label('number',languageStatus() == 'en' ? 'Number' : "নম্বর",['class'=>'col-md-2']) !!}--}}
    {{--                                <div class="col-md-10">--}}
    {{--                                    {!! Form::number('number', old('email'), ['class' => 'form-control']) !!}--}}
    {{--                                    {!! $errors->first('number', '<span class="help-block">:message</span>') !!}--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}


    {{--                        <div class="form-group {{$errors->has('details') ? 'has-error' : ''}}">--}}
    {{--                            <div class="row">--}}
    {{--                                {!! Form::label('details',languageStatus() == 'en' ? 'Details' : "বিস্তারিত",['class'=>'col-md-2 ']) !!}--}}
    {{--                                <div class="col-md-10">--}}
    {{--                                    {!! Form::textarea('details', old('details'), ['placeholder' => languageStatus() == 'en' ? 'write your content here...' : "এখানে আপনার বিষয়বস্তু লিখুন...", 'class' => 'form-control details', 'size' => '5x3']) !!}--}}
    {{--                                    {!! $errors->first('details','<span class="help-block">:message</span>') !!}--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    <div class="card-footer">--}}
    {{--                        <div class="float-right">--}}
    {{--                            {!! Form::button('<i class="fa fa-chevron-circle-right"></i> Submit', ['type' => 'submit', 'class' => 'btn btn-primary float-right', 'id' => 'submit']) !!}--}}
    {{--                        </div>--}}
    {{--                        <div class="clearfix"></div>--}}
    {{--                    </div>--}}
    {{--                    {!! Form::close() !!}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
        });
    </script>
@endsection

