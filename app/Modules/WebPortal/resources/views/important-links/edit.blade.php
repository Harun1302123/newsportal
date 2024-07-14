@php
    if(!$edit_permission){
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

    <!-- Error alert message container -->
    <div class="error_class alert alert-danger mt-2" style="display: none;"></div>

    {!! Form::open([
        'route' => 'important-links.update',
        'method' => 'post',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => 'true',
        'role' => 'form',
    ]) !!}

    <!-- /.panel-heading -->
    <div class="card-body">
        <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">
        <div class="row">
            <div class="form-group col-md-12 {{ $errors->has('title_en') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('title_en', 'Title in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('title_en', old('title', $data->title_en), ['class' => 'form-control required']) !!}
                        {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->has('title_bn') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('title_bn', 'Title in Bangla:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('title_bn', old('title_bn', $data->title_bn), ['class' => 'form-control required']) !!}
                        {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>


            <div class="form-group col-md-12 {{ $errors->has('link') ? 'has-error' : '' }}">
                <div class="row">
                    {!! Form::label('link', 'Link:', ['class' => 'col-md-2 control-label required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('link', old('link', $data->important_link), ['class' => 'form-control required']) !!}
                        {!! $errors->first('link', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="row">
                    {{ Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) }}
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            {{ Form::radio('status', 1, old('status', $data->status) == 1, ['class' => 'form-check-input required', 'id' => 'active_status']) }}
                            {{ Form::label('active_status', 'Active', ['class' => 'form-check-label']) }}
                        </div>
                        <div class="form-check form-check-inline">
                            {{ Form::radio('status', 0, old('status', $data->status) == 0, ['class' => 'form-check-input required', 'id' => 'inactive_status']) }}
                            {{ Form::label('inactive_status', 'Inactive', ['class' => 'form-check-label']) }}
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
    {!! Form::close() !!}<!-- /.form end -->
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

