@php
    if(!$add_permission){
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

    {!! Form::open([
        'route' => 'signup-organizations.store',
        'method' => 'post',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => 'true',
        'role' => 'form',
    ]) !!}

    <div class="card-body">
        <div class="row">

            <div class="form-group col-md-12 {{ $errors->has('organization_name_en') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('organization_name_en', 'Organization Name in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('organization_name_en', old('organization_name_en'), ['class' => 'form-control required']) !!}
                        {!! $errors->first('organization_name_en', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->has('organization_name_bn') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('organization_name_bn', 'Organization Name in Bangla:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('organization_name_bn', old('organization_name_bn'), ['class' => 'form-control required']) !!}
                        {!! $errors->first('organization_name_bn', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12 {{$errors->has('organization_type') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('organizationType', 'organizationType:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::select('organization_type', $organization_types, old('organization_type'), $attributes = ['class' => 'form-control required', 'data-rule-maxlength' => '40', 'placeholder' => 'Select Organization Type', 'id' => 'organizationType']) !!}
                        {!! $errors->first('organization_type', '<span class="text-danger">:message</span>') !!}
                    </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) !!}
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            {!! Form::radio('status', 1, true, [
                                'class' => 'form-check-input required',
                                'id' => 'active_status',
                            ]) !!}
                            {!! Form::label('active_status', 'Active', ['class' => 'form-check-label']) !!}
                        </div>
                        <div class="form-check form-check-inline">
                            {!! Form::radio('status', 0, false, [
                                'class' => 'form-check-input required',
                                'id' => 'inactive_status',
                            ]) !!}
                            {!! Form::label('inactive_status', 'Inactive', ['class' => 'form-check-label']) !!}
                        </div>
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="float-left">
            <a href="{{ $list_route }}">
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
    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
        });
    </script>
@endsection