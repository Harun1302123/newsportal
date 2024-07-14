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
            <h3 class="card-title">{{ $card_title }}</h3>
        </div>
        {!! Form::open([
            'route' => 'credits.store',
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

                <div class="form-group col-md-12  {{ $errors->has('type') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('type', 'Type:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('type', $types, $data->type, [
                                'class' => 'form-control required',
                                'placeholder' => 'Select',
                            ]) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('name_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('name_en', 'Name EN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('name_en', $data->name_en, ['class' => 'form-control required']) !!}
                            {!! $errors->first('name_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>



                <div class="form-group col-md-12 {{ $errors->has('name_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('name_bn', 'Name BN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('name_bn', $data->name_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('name_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>


                <div class="form-group col-md-12 {{ $errors->has('designation_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('designation_en', 'Designation EN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('designation_en', $data->designation_en, ['class' => 'form-control required']) !!}
                            {!! $errors->first('designation_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-12 {{ $errors->has('designation_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('designation_bn', 'Designation BN :', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('designation_bn', $data->designation_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('designation_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-12 {{ $errors->has('details_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('details_en', 'Details EN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('details_en', $data->details_en, ['class' => 'form-control']) !!}
                            {!! $errors->first('details_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-12 {{ $errors->has('details_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('details_bn', 'Details BN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('details_bn', $data->details_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('details_bn', '<span class="help-block">:message</span>') !!}
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
                            <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" id="image" name="image" {{ empty(optional($data)->image) ? 'required' : '' }} value="{{ optional($data)->image }}" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(this, 'show_photo', '1', '')">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>

                    <small class="form-text text-muted">
                        [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB, <strong>Dimension:</strong> Width 300 X 300 Pixel]
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
                <a href="{{ route($list_route) }}">
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
        {!! Form::close() !!}
    </div>
@endsection

@section('footer-script')
    @include('partials.image-upload')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
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
@endsection
