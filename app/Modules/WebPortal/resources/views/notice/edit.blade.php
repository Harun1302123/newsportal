@php
    if (!$edit_permission) {
        die('You have no access right! Please contact with system admin if you have any query.');
    }
@endphp

@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $card_title }} </h3>
        </div>

        {!! Form::open(['route' => 'notices.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

        <div class="card-body">
            <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                <div class="row">
                    <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">
                    {!! Form::label('title','Title:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('title', $data->title, ['class' => 'form-control required']) !!}
                        {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>


            <div class="form-group {{$errors->has('body') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('body','Body:',['class'=>'col-md-2 required-star ']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea('body', $data->body, ['placeholder' => 'write your content here...', 'class' => 'form-control details required', 'size' => '5x3']) !!}
                        {!! $errors->first('body','<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12 {{$errors->has('attachment') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-2 control-label ']) !!}
                    <div class="col-md-10">
                        {!! Form::file('attachment', ['class' => 'form-control', 'id' => 'fileUploadInput','style'=>'height:55%','accept' => '.pdf']) !!}
                        <small class="form-text text-muted">
                            [<strong>Note:</strong> File must be pdf format]
                        </small>                        @if ($data->attachment)
                            <div class="pt-2">
                                <a href="{{ asset($data->attachment) }}" target="_blank"><i class="far fa-file-pdf"></i> View current file</a>
                            </div>
                        @endif
                        <div id="fileUploadMessage"></div>
                    </div>
                </div>
            </div>


            <div class="form-group ">
                <div class="row">
                    {!! Form::label('publish_at', 'Publish Date:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-8">
                        {!! Form::date('publish_at', $data->publish_at, ['class' => 'form-control required']) !!}
                        {!! $errors->first('publish_at','<span class="help-block">:message</span>') !!}

                    </div>
                </div>
            </div>

            <div class="form-group ">
                <div class="row">
                    {!! Form::label('achieve_at', 'Achieve Date:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-8">
                        {!! Form::date('achieve_at', $data->achieve_at, ['class' => 'form-control required']) !!}
                        {!! $errors->first('achieve_at','<span class="help-block">:message</span>') !!}

                    </div>
                </div>
            </div>


            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) !!}
                    <div class="col-md-8">
                        <label>{!! Form::radio('status', 1, !empty($data->status == 1) ? true : false, ['class' => ' required']) !!}
                            Active </label>&nbsp;&nbsp;
                        <label>{!! Form::radio('status', 0, !empty($data->status == 0) ? true : false, ['class' => 'required']) !!}
                            Inactive </label>&nbsp;&nbsp;
                    </div>
                </div>
            </div>



        </div>

        <div class="card-footer">
            <div class="float-left">
                <a href="{{ route($list_route) }}">
                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                </a>
            </div>
            <div class="float-right">
                {!! Form::button('<i class="fa fa-chevron-circle-right"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary float-right', 'id' => 'submit']) !!}
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@section('footer-script')
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
