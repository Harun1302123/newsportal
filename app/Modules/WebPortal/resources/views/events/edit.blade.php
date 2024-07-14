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
        {!! Form::open([
            'route' => 'events.store',
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

                <div class="form-group col-md-12 {{ $errors->has('heading_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('heading_en', 'Heading in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('heading_en', $data->heading_en, ['class' => 'form-control required']) !!}
                            {!! $errors->first('heading_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('heading_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('heading_bn', 'Heading in Bangla:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('heading_bn', $data->heading_bn, ['class' => 'form-control']) !!}
                            {!! $errors->first('heading_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12 {{ $errors->has('details_en') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('details_en', 'Details in English:', ['class' => 'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('details_en', $data->details_en, ['class' => 'form-control required details', 'size' => '5x3']) !!}
                            {!! $errors->first('details_en', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-12 {{ $errors->has('details_bn') ? 'has-error' : '' }}">
                    <div class="row">
                        {!! Form::label('details_bn', 'Details in Bangla:', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('details_bn', $data->details_bn, ['class' => 'form-control required details', 'size' => '5x3']) !!}
                            {!! $errors->first('details_bn', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="form-group col-md-6  {{$errors->has('event_category') ? 'has-error' : ''}}">
                    <div class="row">
                        {!! Form::label('event_category','Category:',['class'=>'col-md-4 control-label required-star']) !!}
                        <div class="col-md-8">
                            {!! Form::select('event_category',$event_categories, $data->event_category, [
                                'class' => 'form-control required select2',
                                'placeholder' => 'Select',
                            ]) !!}
                            {!! $errors->first('event_category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 ">
                    <div class="row">
                        {!! Form::label('event_date', 'Event Date:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::input('dateTime-local', 'event_date', $data->event_date, ['class' => 'form-control']) !!}

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
                        [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB]
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
                <a href="{{route($list_route)}}">
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
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script type="text/javascript" src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>

    <script>
        $("#form_id").validate({
            errorPlacement: function() {
                return true;
            }
        });

        tinymce.init({
            selector: '.details',
            plugins: 'lists',

            toolbar: false,
            height: 250,

            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
@endsection <!--- footer script--->
