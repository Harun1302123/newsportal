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

        {!! Form::open(['route' => 'menu-items.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

        <div class="card-body">
            <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">
            <div class="form-group {{$errors->has('parent_id') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('title_en','Parent Menu:',['class'=>'col-md-2 control-label required-star']) !!}
{{--                    <div class="col-md-10">--}}
{{--                        {!! Form::select('parent_id', $menu_items, \App\Libraries\Encryption::encodeId($data->parent_id), ['class'=>'form-control select2 required','style' => 'width:100%', 'placeholder' => '']) !!}--}}
{{--                        {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}--}}
{{--                    </div>--}}

                    <div class="col-md-10">
                        {!! Form::select('parent_id', $menu_items, $data->parent_id, ['class'=>'form-control select2 required','style' => 'width:100%', 'placeholder' => '']) !!}
                        {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('name','Name:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('name', $data->name, ['class' => 'form-control required']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('name_bn') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('name_bn','Name BN:',['class'=>'col-md-2']) !!}
                    <div class="col-md-10">
                        {!! Form::text('name_bn', $data->name_bn, ['class' => 'form-control']) !!}
                        {!! $errors->first('name_bn', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('slug','Slug:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('slug', $data->slug, ['class' => 'form-control required']) !!}
                        {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
                        <small class="form-text text-muted">
                            [<strong>Slug name will be unique.</strong>]
                        </small>
                    </div>
                </div>
            </div>


            <div class="form-group {{$errors->has('ordering') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('ordering','Ordering:',['class'=>'col-md-2 required-star']) !!}
                    <div class="col-md-10">
                        {!! Form::text('ordering', $data->ordering, ['class' => 'form-control required']) !!}
                        {!! $errors->first('ordering', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>



            <div class="form-group {{$errors->has('heading_en') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('heading_en','Heading EN:',['class'=>'col-md-2']) !!}
                    <div class="col-md-10">
                        {!! Form::text('heading_en', $data->heading_en, ['class' => 'form-control']) !!}
                        {!! $errors->first('heading_en', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('heading_bn') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('heading_bn','Heading BN:',['class'=>'col-md-2']) !!}
                    <div class="col-md-10">
                        {!! Form::text('heading_bn', $data->heading_bn, ['class' => 'form-control']) !!}
                        {!! $errors->first('heading_bn', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>


            <div class="form-group {{$errors->has('content_en') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('content_en','Content EN:',['class'=>'col-md-2 ']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea('content_en', $data->content_en, ['placeholder' => 'write your content here...', 'class' => 'form-control details', 'size' => '5x3']) !!}
                        {!! $errors->first('content_en','<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group {{$errors->has('content_bn') ? 'has-error' : ''}}">
                <div class="row">
                    {!! Form::label('content_bn','Content BN:',['class'=>'col-md-2 ']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea('content_bn', $data->content_bn, ['placeholder' => 'write your content here...', 'class' => 'form-control details', 'size' => '5x3']) !!}
                        {!! $errors->first('content_bn','<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="row">
                    {{ Form::label('status', 'Status:', ['class' => 'col-md-2 control-label required-star']) }}
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

        <div class="card-footer">
            <div class="float-left">
                <a href="{{ route('menu-items.list') }}">
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
    <script type="text/javascript" src="{{asset('plugins/tinymce/tinymce.min.js')}}"></script>

    <script>
        $("#form_id").validate({
            errorPlacement: function () {
                return true;
            }
        });
        tinymce.init({
            selector: '.details',
            plugins: 'lists code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code', // Customize the toolbar,
            height: 250,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
@endsection
