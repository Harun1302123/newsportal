@php
    if (!$add_permission) {
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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Create New Communication </h3>
                </div>

                {!! Form::open(['route' => 'communications.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

                <!-- /.panel-heading -->
                <div class="card-body">
                    <div class="form-group row {{$errors->has('communication_type') ? 'has-error' : ''}}">
                        {!! Form::label('communication_type','Type:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            <label>{!! Form::radio('communication_type',  'organization',  !empty(old('communication_type') == 'organization') ? true : false, ['class' => 'required type']) !!}
                                Organization </label>
                            <label>{!! Form::radio('communication_type', 'individual', !empty(old('communication_type') == 'individual') ? true : false, ['class' => 'required type']) !!}
                                Individual </label>
                        </div>
                    </div>


                    <div class="form-group row {{$errors->has('user_ids') ? 'has-error' : ''}}" id="user_list"
                         style="display: none;">
                        {!! Form::label('user_ids','User List:',['class'=>'col-md-2 control-label required-star','id'=>'user_list']) !!}
                        <div class="col-md-10">
                            {!! Form::select('user_ids[]', $user_list, old('user_ids'), ['class' => 'form-control select2 user_list', 'multiple'=>'multiple']) !!}
                            {!! $errors->first('user_ids','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>

                    <div class="form-group row {{$errors->has('status') ? 'has-error' : ''}}" id="organization_type"
                         style="display: none;">
                        {!! Form::label('organization_type','Organization Type:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('organization_type', $organization_types, old('organization_type'), ['class' => 'form-control organization_type']) !!}
                        </div>
                    </div>

                    <div class="form-group row {{$errors->has('organization_list') ? 'has-error' : ''}}"
                         id="organization_list" style="display: none;">
                        {!! Form::label('organization_list','Organization List:',['class'=>'col-md-2 control-label required-star user_list']) !!}
                        <div class="col-md-10">
                            {!! Form::select('organization_list[]', $organization_list, old('organization_list'), ['class' => 'form-control organization_list select2','id'=>'organization', 'multiple'=>'multiple']) !!}
                            {!! $errors->first('organization_list','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>

                    <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('title','Title:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::text('title', old('title'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('description','Description:',['class'=>'col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::textarea('description', old('description'), ['class' => 'form-control','style' => 'height:150px']) !!}
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{$errors->has('start_date') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('start_date','Start Date:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::date('start_date', old('start_date'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('end_date') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('end_date','End Date:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::date('end_date', old('end_date'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{$errors->has('start_time') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('start_time','Start Time:',['class'=>'col-md-2 ']) !!}
                            <div class="col-md-10">
                                {!! Form::time('start_time', old('start_time'), ['class' => 'form-control']) !!}
                                {!! $errors->first('start_time', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('end_time') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('end_time','End Time:',['class'=>'col-md-2 ']) !!}
                            <div class="col-md-10">
                                {!! Form::time('end_time', old('end_time'), ['class' => 'form-control']) !!}
                                {!! $errors->first('end_time', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group col-md-12 {{$errors->has('attachment') ? 'has-error' : ''}}">
                            <div class="row">
                                {!! Form::label('attachment','Attrachment :',['class'=>'col-md-2 control-label']) !!}
                                <div class="col-md-10">
                                    {!! Form::file('attachment', ['class' => 'form-control', 'id' => 'fileUploadInput' ,'style'=>'height:100%', 'accept'=>".doc, .docx, .xls, .xlsx, .pdf"]) !!}
                                    <div id="fileUploadMessage"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row {{$errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status','Status:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            <label>{!! Form::radio('status',  0,  null, ['class' => 'required', 'checked']) !!}
                                Draft </label>&nbsp;&nbsp;
                            <label>{!! Form::radio('status', 1, null, ['class' => 'required']) !!}
                                Publish </label>&nbsp;&nbsp;
                        </div>
                    </div>

                    <div class="form-group row {{$errors->has('notification_type') ? 'has-error' : ''}}">
                        {!! Form::label('notification_type','Notification Type:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            <label>
                                {!! Form::radio('notification_type',  1 ,  old('notification_type') == 1 ? 1 : 0, ['class' => 'required']) !!}
                                Email
                            </label>&nbsp;&nbsp;
                            <label>
                                {!! Form::radio('notification_type', 2 , old('notification_type') == 2 ? 1 : 0, ['class' => 'required']) !!}
                                Sms
                            </label>
                            <label>
                                {!! Form::radio('notification_type', 3 , old('notification_type') == 3 ? 1 : 0, ['class' => 'required']) !!}
                                Both
                            </label>
                        </div>
                    </div>
                </div><!-- /.box -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('communications.list')  }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                        </a>
                    </div>
                    <div class="float-right">
                        @if($add_permission)
                            <button type="submit" class="btn btn-primary float-right" id="submit">
                                <i class="fa fa-chevron-circle-right"></i> Save
                            </button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                {!! Form::close() !!}<!-- /.form end -->
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>

    <script>

        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });

            $(".select2").select2();

            $('input[name="communication_type"]:checked').trigger('change');
            $('.organization_type').trigger('change');
        });

        $(".type").change(function () {
            if ($(this).val() === "individual") {
                $('#organization_type').hide();
                $('#organization_list').hide();
                $('#user_list').css("display", "flex");
            } else if ($(this).val() === "organization") {
                $('#user_list').hide()
                $('#organization_type').css("display", "flex");
                $('.organization_type').trigger('change');
            } else {
                $('#user_list').hide()
                $('#organization_type').hide();


            }
        });
        $(".organization_type").change(function () {
            var _token = $('input[name="_token"]').val();
            var typeId = $(this).val()
            $(".organization_list").trigger('change');

            if (typeId !== '0') {
                $(".organization_list").prop('disabled', true);
                $(".organization_list").val([]).trigger('change');

                $.ajax({
                    type: "post",
                    url: "{{ route('organization_type_wise_organizations') }}",
                    data: {
                        _token: _token,
                        typeId: typeId
                    },
                    success: function (response) {
                        if (response.responseCode == 1) {
                            var option = '';
                            setTimeout(function () {
                                $.each(response.data, function (id, value) {
                                    option += '<option value="' + id + '">' + value + '</option>';
                                });
                                $('.organization_list').html(option);
                                $(".organization_list").prop('disabled', false);
                            });
                            $('#organization_list').css("display", "flex");
                        }
                    }
                });
            } else {
                $("#organization_list").hide()
            }
        });

        $("#organization").on('input', function () {
            var selectedValues = $(this).val();
            if (selectedValues.includes('0')) {
                selectedValues = ['0'];
                $(this).val(selectedValues).trigger('change');
            }
        });

        $(".user_list").on('input', function () {
            var selectedValues = $(this).val();
            if (selectedValues.includes('0')) {
                selectedValues = ['0'];
                $(this).val(selectedValues).trigger('change');
            }
        });
    </script>
@endsection <!--- footer script--->
