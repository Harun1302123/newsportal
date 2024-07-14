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

        {!! Form::open([
           'route' => 'publications.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
        ]) !!}
        <!-- /.panel-heading -->
        <div class="card-body">
            <div class="row">

                <div class="form-group col-md-12  {{ $errors->has('photo_category') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('category', 'Category:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('category', $categories, null, [
                                'class' => 'form-control required select2',
                                'placeholder' => 'Select',
                            ]) !!}
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('name_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_en', 'Title EN:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_en', null, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('title_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('title_bn', 'Title BN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title_bn', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('title_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('description_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('description_en', 'Description EN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('description_en', null, ['class' => 'form-control', 'size' => '5x3']) !!}
                            {!! $errors->first('description_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('description_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('description_bn', 'Description EN:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('description_bn', null, ['class' => 'form-control',  'size' => '5x3']) !!}
                            {!! $errors->first('description_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{$errors->has('attachment') ? 'has-error' : ''}}">
                        <div class="row">
                            {!! Form::label('attachment','Attrachment :',['class'=>'col-md-2 control-label required-star']) !!}
                            <div class="col-md-10">
                                {!! Form::file('attachment', ['class' => 'form-control required', 'id' => 'fileUploadInput' ,'style'=>'height:100%', 'accept' => '.pdf']) !!}
                                <div id="fileUploadMessage"></div>
                            </div>
                        </div>
                    </div>

                <div class="form-group row col-md-12">
                    {!! Form::label('image', 'Image:', ['class' => 'col-md-2 required-star']) !!}

                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input required {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                       id="image" name="image" accept="image/jpeg, image/png, image/jpg"
                                       onchange="previewImage(this, 'show_photo', '1', '')">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>

                        <small class="form-text text-muted">
                            [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB]
                        </small>

                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

                        {{-- Show image --}}
                        <div class="mb-1">
                            {!! CommonFunction::getImageFromURL('show_photo') !!}
                        </div>
                    </div>
                </div>


                <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('status', 'Status:', ['class' => 'col-md-4 control-label required-star']) !!}

                        <div class="col-md-8">
                            <label>{!! Form::radio('status', 1, true, ['class' => 'required', 'checked']) !!}
                                Active </label>&nbsp;&nbsp;
                            <label>{!! Form::radio('status', 0, false, ['class' => 'required']) !!}
                                Inactive </label>&nbsp;&nbsp;
                            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                        </div>
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
                @if ($add_permission)
                    <button type="submit" class="btn btn-primary float-right" id="submit">
                        <i class="fa fa-chevron-circle-right"></i> Save
                    </button>
                @endif
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
@endsection
