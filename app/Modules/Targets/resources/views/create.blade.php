@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"> Create target</h3>
                    <!-- /.card-tools -->
                </div>

                <!-- /.card-header -->
                {!! Form::open(['route' => 'targets.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

                <div class="card-body">
                    <div class="form-group col-md-12 {{$errors->has('goal_id') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('goal_id','Goal:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::select('goal_id', $goals, '', ['class'=>'form-control required', 'placeholder'=>'Please select goal']) !!}
                                {!! $errors->first('goal_id','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{$errors->has('goal_id') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('order','Order:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::text('order', old('order'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('order','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{$errors->has('target_number_en') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('target_number_en','Target Number EN:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::text('target_number_en', old('target_number_en'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('target_number_en', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{$errors->has('target_number_bn') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('target_number_bn','Target Number BN:',['class'=>'col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('target_number_bn', old('target_number_bn'), ['class' => 'form-control']) !!}
                                {!! $errors->first('target_number_bn', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{$errors->has('title_en') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('title_en','Title EN:',['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::text('title_en', old('title_en'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 {{$errors->has('title_bn') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('title_bn','Title BN:',['class'=>'col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('title_bn', old('title_bn'), ['class' => 'form-control']) !!}
                                {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12 d-none {{$errors->has('status') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('status', 'Status:', ['class'=>'col-md-2 required-star']) !!}
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 1, true, ['class' => 'form-check-input required', 'id' => 'active_status']) !!}
                                    {!! Form::label('active_status', 'Active', ['class' => 'form-check-label']) !!}
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 0, false, ['class' => 'form-check-input required', 'id' => 'inactive_status']) !!}
                                    {!! Form::label('inactive_status', 'Inactive', ['class' => 'form-check-label']) !!}
                                </div>
                                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('targets.list')  }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                        </a>
                    </div>
                    <div class="float-right">
                        {!! Form::button('<i class="fa fa-chevron-circle-right"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary float-right', 'id' => 'submit']) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                {!! Form::close() !!}
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
    </div>
@endsection
<!--content section-->

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

    <script>
        $(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return false;
                }
            });
        });

        {{--function uniqueTargetCheck(element, index) {--}}
        {{--    var languageValue = document.getElementsByName('language[' + index + ']')[0].value;--}}
        {{--    var targetNumber = $(element).val();--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ url("targets/unique-target-check") }}',--}}
        {{--        type: 'get',--}}
        {{--        dataType: 'json',--}}
        {{--        data: {--}}
        {{--            targetNumber: targetNumber,--}}
        {{--            language: languageValue,--}}
        {{--        },--}}
        {{--        success: function (response) {--}}
        {{--            let messageElement = $('<span class="unique-target-message text-red"></span>');--}}
        {{--            $(element).next('.unique-target-message').remove();--}}

        {{--            if (response.status == 1) {--}}
        {{--                $(element).addClass('error');--}}
        {{--                messageElement.text('This Target number is already existed.');--}}
        {{--                messageElement.insertAfter(element);--}}
        {{--            } else {--}}
        {{--                $(element).removeClass('error');--}}
        {{--                $(element).next('.unique-target-message').remove();--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error: function (jqXHR, textStatus, errorThrown) {--}}
        {{--            console.log(errorThrown);--}}
        {{--        },--}}
        {{--    });--}}
        {{--}--}}
    </script>
@endsection
