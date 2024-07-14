@php
    if (!$add_permission) {
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

        {!! Form::open(['route' => 'homepage.categories.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

        <div class="card-body">
            <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('type','Type:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::select('type', $type,null, ['class' => 'form-control required']) !!}
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('name','Name:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('name', old('name'), ['class' => 'form-control required']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('status') ? 'has-error' : ''}}">
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
                <a href="{{ route('homepage.categories.list') }}">
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
