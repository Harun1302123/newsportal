@extends('frontend.layouts.master')
@section('style')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/intlTelInput/css/intlTelInput.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('content')
    <main class="site-main-content page-height">
        <div class="container">
            @include('partials.messages')
            <div class="nfis-content-container">

                {!! Form::open([
                    'route' => 'signup.store',
                    'method' => 'post',
                    'id' => 'form_id',
                    'enctype' => 'multipart/form-data',
                    'files' => 'true',
                    'role' => 'form',
                ]) !!}

                <div class="nfis-login-content signup-box">
                    <div class="form-block-item text-center">
                        <h3>{{ languageStatus() == 'en' ? 'Registration Form' : "রেজিষ্ট্রেশন ফর্ম" }}</h3>
                    </div>
                    <div class="form-block-item">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('organization_type') ? 'has-error' : '' }}">
                                    {!! Form::label('organizationType', (languageStatus() == 'en' ? 'Organisation Type' : 'প্রতিষ্ঠানের ধরন'), ['class' => 'required-star']) !!}
                                    {!! Form::select(
                                        'organization_type',
                                        $organization_types,
                                        old('organization_type'),
                                        $attributes = [
                                            'class' => 'form-control required',
                                            'data-rule-maxlength' => '40',
                                            'placeholder' => (languageStatus() == 'en' ? 'Select Organization Type' : ' প্রতিষ্ঠানের ধরন নির্বাচন করুন'),
                                            'onchange' => "loadChildOptions('organizationType', this.value, 'organizationName')",
                                            'id' => 'organizationType',
                                        ],
                                    ) !!}
                                    {!! $errors->first('organization_type', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('organization_name') ? 'has-error' : '' }}">
                                    {!! Form::label('organizationName',  (languageStatus() == 'en' ? 'Organization Name' : 'প্রতিষ্ঠানের নাম'), ['class' => 'required-star']) !!}
                                    {!! Form::select(
                                        'organization_name',
                                        [],
                                        old('organization_name'),
                                        $attributes = [
                                            'class' => 'form-control required',
                                            'data-rule-maxlength' => '40',
                                            'placeholder' =>  (languageStatus() == 'en' ? 'Select Organization Name' : 'প্রতিষ্ঠানের নাম নির্বাচন করুন'),
                                            'id' => 'organizationName',
                                        ],
                                    ) !!}
                                    {!! $errors->first('organization_name', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('central_email') ? 'has-error' : '' }}">
                                    {!! Form::label('central_email',  (languageStatus() == 'en' ? 'Central Email Address for NFIS' : 'এনএফআইএস-এর জন্য কেন্দ্রীয় ইমেল ঠিকানা'), ['class' => 'required-star']) !!}
                                    {!! Form::email('central_email', old('central_email'), [
                                        'class' => 'form-control required',
                                        'id' => 'central_email',
                                        'placeholder' => (languageStatus() == 'en' ? 'Email Address' : 'ইমেইল ঠিকানা') ,
                                    ]) !!}
                                    {!! $errors->first('central_email', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                                    {!! Form::label('phone_number',  (languageStatus() == 'en' ? 'Phone Number' : 'ফোন নম্বর'), ['class' => 'required-star']) !!}
                                    {!! Form::text(
                                        'phone_number',
                                        old('phone_number'),
                                        $attributes = [
                                            'class' => 'form-control required bd_mobile',
                                            'placeholder' =>(languageStatus() == 'en' ? 'Enter Mobile Number' : 'মোবাইল নম্বর লিখুন') ,
                                            'maxlength' => "10",
                                            'id' => 'phone_number',
                                        ],
                                    ) !!}
                                    {!! $errors->first('phone_number', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-block-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>{{ languageStatus() == 'en' ? 'Focal Point' : "ফোকাল পয়েন্ট" }}</h4>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('fp_name') ? 'has-error' : '' }}">
                                    {!! Form::label('fp_name',  (languageStatus() == 'en' ? 'Name' : 'নাম')) !!}
                                    <div class="input-icon-right">
                                        {!! Form::text(
                                            'fp_name',
                                            old('fp_name'),
                                            $attributes = ['class' => 'form-control', 'placeholder' => (languageStatus() == 'en' ? 'Name' : 'নাম'), 'id' => 'fp_name'],
                                        ) !!}
                                        {!! $errors->first('fp_name', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('fp_designation') ? 'has-error' : '' }}">
                                    {!! Form::label('fp_designation', (languageStatus() == 'en' ? 'Designation' : 'উপাধি')) !!}
                                    <div class="input-icon-right">
                                        {!! Form::text(
                                            'fp_designation',
                                            old('fp_designation'),
                                            $attributes = ['class' => 'form-control', 'placeholder' => (languageStatus() == 'en' ? 'Designation' : 'উপাধি'), 'id' => 'fp_designation'],
                                        ) !!}
                                        {!! $errors->first('fp_designation', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('fp_phone_number') ? 'has-error' : '' }}">
                                    {!! Form::label('fp_phone_number',(languageStatus() == 'en' ? 'Phone Number' : 'ফোন নম্বর')) !!}
                                    {!! Form::text(
                                        'fp_phone_number',
                                        old('fp_phone_number'),
                                        $attributes = [
                                            'class' => 'form-control bd_mobile',
                                            'placeholder' => (languageStatus() == 'en' ? 'Enter Mobile Number' : 'মোবাইল নম্বর লিখুন'),
                                            'maxlength' => "10",
                                            'id' => 'fp_phone_number',
                                        ],
                                    ) !!}
                                    {!! $errors->first('fp_phone_number', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('fp_email') ? 'has-error' : '' }}">
                                    {!! Form::label('fp_email', (languageStatus() == 'en' ? 'Email' : 'ইমেইল')) !!}
                                    {!! Form::email('fp_email', old('fp_email'), [
                                        'class' => 'form-control',
                                        'id' => 'fp_email',
                                        'placeholder' => (languageStatus() == 'en' ? 'Email Address' : 'ইমেইল ঠিকানা'),
                                    ]) !!}
                                    {!! $errors->first('fp_email', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-block-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>{{ languageStatus() == 'en' ? 'Deputy Focal Point' : "ডেপুটি ফোকাল পয়েন্ট" }}</h4>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('dfp_name') ? 'has-error' : '' }}">
                                    {!! Form::label('dfp_name', (languageStatus() == 'en' ? 'Name' : 'নাম')) !!}
                                    <div class="input-icon-right">
                                        {!! Form::text(
                                            'dfp_name',
                                            old('dfp_name'),
                                            $attributes = ['class' => 'form-control', 'placeholder' => (languageStatus() == 'en' ? 'Name' : 'নাম'), 'id' => 'dfp_name'],
                                        ) !!}
                                        {!! $errors->first('dfp_name', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('dfp_designation') ? 'has-error' : '' }}">
                                    {!! Form::label('dfp_designation', (languageStatus() == 'en' ? 'Designation' : 'উপাধি')) !!}
                                    <div class="input-icon-right">
                                        {!! Form::text(
                                            'dfp_designation',
                                            old('dfp_designation'),
                                            $attributes = ['class' => 'form-control', 'placeholder' => (languageStatus() == 'en' ? 'Designation' : 'উপাধি'), 'id' => 'dfp_designation'],
                                        ) !!}
                                        {!! $errors->first('dfp_designation', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('dfp_phone_number') ? 'has-error' : '' }}">
                                    {!! Form::label('dfp_phone_number', (languageStatus() == 'en' ? 'Phone Number' : 'ফোন নম্বর')) !!}
                                    {!! Form::text(
                                        'dfp_phone_number',
                                        old('dfp_phone_number'),
                                        $attributes = [
                                            'class' => 'form-control bd_mobile',
                                            'placeholder' => (languageStatus() == 'en' ? 'Enter Mobile Number' : 'মোবাইল নম্বর লিখুন'),
                                            'maxlength' => "10",
                                            'id' => 'dfp_phone_number',
                                        ],
                                    ) !!}
                                    {!! $errors->first('dfp_phone_number', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('dfp_email') ? 'has-error' : '' }}">
                                    {!! Form::label('dfp_email', (languageStatus() == 'en' ? 'Email' : 'ইমেইল')) !!}
                                    {!! Form::email('dfp_email', old('dfp_email'), [
                                        'class' => 'form-control',
                                        'id' => 'dfp_email',
                                        'placeholder' => (languageStatus() == 'en' ? 'Email Address' : 'ইমেইল ঠিকানা') ,
                                    ]) !!}
                                    {!! $errors->first('dfp_email', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-block-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                    {!! Form::label('preferredUserID',(languageStatus() == 'en' ? 'Preferred User ID' : 'পছন্দের ইউজার আইডি') , ['class' => 'required-star']) !!}
                                    <div class="input-icon-right">
                                        {!! Form::text(
                                            'user_id',
                                            old('user_id'),
                                            $attributes = ['class' => 'form-control required', 'id' => 'preferredUserID'],
                                        ) !!}
                                        {{-- <span class="input-icon">.nfis</span> --}}
                                        <small class="form-text text-muted">
                                            [<strong>{{ languageStatus() == 'en' ? 'Give user id:' : "ইউজার আইডি দিন" }} </strong> *.bb.nfis]
                                        </small>
                                        {!! $errors->first('user_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden">
                                <div class="form-group">
                                    <label for="create_pass">Create Password</label>
                                    <div class="input-icon-right">
                                        <input type="text" class="form-control" id="create_pass" placeholder="Password">
                                        <span class="input-icon icon-password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden">
                                <div class="form-group">
                                    <label for="confirm_pass">Confirm Password</label>
                                    <div class="input-icon-right">
                                        <input type="text" class="form-control" id="confirm_pass" placeholder="Password">
                                        <span class="input-icon icon-password-eye"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-block-item">
                        <div class="flex-center px-4 pb-3">
                            <button type="submit" class="nfis-btn btn">{{ languageStatus() == 'en' ? 'Submit' : "জমা দিন" }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/intlTelInput/js/intlTelInput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/intlTelInput/js/utils.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function() {
            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                }
            });

            $("#phone_number").intlTelInput({
                hiddenInput: "phone_number",
                onlyCountries: ["bd"],
                initialCountry: "BD",
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
            });

            $("#fp_phone_number").intlTelInput({
                hiddenInput: "fp_phone_number",
                onlyCountries: ["bd"],
                initialCountry: "BD",
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
            });

            $("#dfp_phone_number").intlTelInput({
                hiddenInput: "dfp_phone_number",
                onlyCountries: ["bd"],
                initialCountry: "BD",
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
            });

            // $("#organizationType").select2({});
        });

        function loadChildOptions(parentId, parentValue, childId) {
            let actionUrl = "get-organigation-name"; //set method url
            loadOptions(parentId, parentValue, childId, actionUrl, 'Select Organization Type')
        }

        $(document).ready(function() {
            $("#preferredUserID").on('input', function() {
                var preferredUserIDValue = $(this).val();
                if (preferredUserIDValue) {
                    $.ajax({
                        url: '/check-userid',
                        method: 'POST',
                        data: {
                            user_id: preferredUserIDValue,
                            _token : $('input[name="_token"]').val()
                        },
                        success: function(response) { 
                            if (response.status == 'failed') {
                                toastr.warning(response.message)
                            }else{
                                toastr.clear();
                            }
                        },
                        error: function error(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });
    </script>
@endsection
