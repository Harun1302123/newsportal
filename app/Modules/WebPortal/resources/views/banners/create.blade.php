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

        {!! Form::open(['route' => 'banners.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

        <div class="card-body">
            <div class="form-group {{$errors->has('title_en') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('title_en','Title in English:',['class'=>'col-md-2']) !!}
                    <div class="col-md-10">
                        {!! Form::text('title_en', old('title_en'), ['class' => 'form-control']) !!}
                        {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('title_bn') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('title_bn','Title in Bangla:',['class'=>'col-md-2']) !!}
                    <div class="col-md-10">
                        {!! Form::text('title_bn', old('title_bn'), ['class' => 'form-control']) !!}
                        {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('description_en') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('description_en','Description in English:',['class'=>'col-md-2 ']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea('description_en', old('description_en'), ['placeholder' => 'write your content here...', 'class' => 'form-control details', 'size' => '5x3']) !!}
                        {!! $errors->first('description_en','<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('description_bn') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('description_bn','Description in Bangla:',['class'=>'col-md-2 ']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea('description_bn', old('description_bn'), ['placeholder' => 'write your content here...', 'class' => 'form-control details', 'size' => '5x3']) !!}
                        {!! $errors->first('description_bn','<span class="help-block">:message</span>') !!}
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

            <div class="form-group row">
                {!! Form::label('image', 'Image:', ['class'=>'col-md-2 required-star']) !!}

                <div class="col-md-10">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input required {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image" accept="image/jpeg, image/jpg, image/png" onchange="previewImage(this, 'show_photo', '1', '')">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>

                    <small class="form-text text-muted">
                        [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB, <strong>Dimension:</strong> Width 1280 X 435 Pixel]
                    </small>

                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

                    {{--Show image--}}
                    <div class="mb-1">
                        {!! CommonFunction::getImageFromURL('show_photo') !!}
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
