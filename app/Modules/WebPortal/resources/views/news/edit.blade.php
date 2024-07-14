@php
    if (!$edit_permission) {
        die('You have no access right! Please contact with system admin if you have any query.');
    }
@endphp

@extends('layouts.admin')
@section('header-resources')
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">

    <style>
        .border_dashed {
            margin: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $card_title }} </h3>
        </div>
        {!! Form::open([
            'route' => 'news.store',
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
                        {!! Form::label('title_en', 'Title EN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_en', $data->title_en, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('title_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_bn', 'Title BN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_bn', $data->title_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('content_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('content_en', 'Content EN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('content_en', $data->content_en, ['class' => 'form-control required details']) !!}
                            {!! $errors->first('content_en', '<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('content_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('content_bn', 'Content BN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('content_bn', $data->content_bn, ['class' => 'form-control required details']) !!}
                            {!! $errors->first('content_bn', '<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('content_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('category_id', 'News Category:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select(
                                'category_id',
                                $news_category,
                                $data->category_id,
                                $attributes = [
                                    'class' => 'form-control required',
                                    'data-rule-maxlength' => '40',
                                    'placeholder' => 'Select One',
                                    'id' => 'category_id',
                                ],
                            ) !!}
                            {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
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
            <div class="form-group row">
                {!! Form::label('image', 'Image:', ['class'=>'col-md-2 required-star']) !!}

                <div class="col-md-10">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image" {{ empty(optional($data)->image) ? 'required' : '' }} value="{{ optional($data)->image }}" accept="image/jpeg, image/jpg, image/png" onchange="previewImage(this, 'show_photo', '1', '')">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>

                    <small class="form-text text-muted">
                        [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB, <strong>Dimension:</strong> 1280x435 or 494x480 Pixel]
                    </small>

                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

                    {{--Show image--}}
                    <div class="mb-1">
                        {!! CommonFunction::getImageFromURL('show_photo', optional($data)->image) !!}
                    </div>
                </div>
            </div>




        </div><!-- /.box -->

        <div class="card-footer">
            <div class="float-left">
                <a href="{{ $list_route }}">
                    {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                </a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-primary float-right">
                    <i class="fa fa-chevron-circle-right"></i> Update
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
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                },
            });
            $(".select2").select2();
        });

        tinymce.init({
            selector: '.details',
            plugins: 'lists',
            toolbar: false,
            height: 250,

            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            },
            init_instance_callback: function(editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });

    </script>
@endsection <!--- footer script--->
