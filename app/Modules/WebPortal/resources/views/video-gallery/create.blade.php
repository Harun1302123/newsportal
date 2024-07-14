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
            <h3 class="card-title"> {{ $card_title }} </h3>
        </div>

        {!! Form::open([
            'route' => 'video-galleries.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
        ]) !!}
        <!-- /.panel-heading -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-12  {{ $errors->has('title_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_en', 'Title in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_en', null, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12  {{ $errors->has('title_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_bn', 'Title in Bangla:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_bn', null, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12 {{$errors->has('url') ? 'has-error' : ''}}">
                    <div class="row">
                        {!! Form::label('url','URL:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('url', null, ['class' => 'form-control required',  'placeholder' => 'https://youtu.be/Dxu5ucZ0WXX'], ) !!}
                            {!! $errors->first('url','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6  {{ $errors->has('tutorial_category') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('tutorial_category', 'Category:', ['class' => 'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8">
                            {!! Form::select('tutorial_category', $tutorial_categories, null, [
                                'class' => 'form-control required select2',
                                'placeholder' => 'Select',
                            ]) !!}
                            {!! $errors->first('tutorial_category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="row">
                        {!! Form::label('video_length','Video Length:',['class'=>'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('video_length', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="row">
                        {!! Form::label('ordering','Order:',['class'=>'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::number('ordering', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group  col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('status', 'Status:', ['class' => 'col-md-4 required-star']) !!}
                        <div class="col-md-6">
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
                <div class="form-group col-md-12 row">
                    {!! Form::label('image', 'Background Image:', ['class'=>'col-md-2 required-star']) !!}

                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input required {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image" accept="image/jpeg, image/jpg, image/png" onchange="previewImage(this, 'show_photo', '1', '1280x720')">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>

                        <small class="form-text text-muted">
                            [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB, <strong>Dimension:</strong> Width 472 X 309 Pixel]
                        </small>

                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

                        {{--Show image--}}
                        <div class="mb-1">
                            {!! CommonFunction::getImageFromURL('show_photo') !!}
                        </div>
                    </div>
                </div>

            </div>

        </div><!-- /.box -->

        <div class="card-footer">
            <div class="float-left">
                <a href="{{ route('video-galleries.list') }}">
                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                </a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-primary float-right" id="submit">
                    <i class="fa fa-chevron-circle-right"></i> Save
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}<!-- /.form end -->
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
@endsection <!--- footer script--->
