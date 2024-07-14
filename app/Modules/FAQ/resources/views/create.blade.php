@php
    if (!$add_permission) {
        die('You have no access right! Please contact with system admin if you have any query.');
    }
@endphp
@extends('layouts.admin')

@section('header-resources')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Create New FAQ </h3>
                </div>

                {!! Form::open(['route' => 'faq.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

                <!-- /.panel-heading -->
                <div class="card-body">
                    <div class="form-group row {{$errors->has('title') ? 'has-error' : ''}}">
                        {!! Form::label('title','Title:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::text('title', null, ['class' => 'form-control required']) !!}
                            {!! $errors->first('title','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group row {{$errors->has('details') ? 'has-error' : ''}}">
                        {!! Form::label('details','Details:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('details', null, ['class' => 'form-control required details','style' => 'height:200px']) !!}
                            {!! $errors->first('details','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('ordering','Order:',['class'=>'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::number('ordering', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>


                    <div class="form-group row {{$errors->has('status') ? 'has-error' : ''}}">
                            {!! Form::label('status','Status:',['class'=>'col-md-2 control-label required-star']) !!}
                            <div class="col-md-10">
                                <label>{!! Form::radio('status',  1,  null, ['class' => 'required', 'checked']) !!}
                                    Active </label>&nbsp;&nbsp;
                                <label>{!! Form::radio('status', 0, null, ['class' => 'required']) !!}
                                    Inactive </label>&nbsp;&nbsp;
                            </div>
                    </div>
                </div><!-- /.box -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('faq.list')  }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                        </a>
                    </div>
                    <div class="float-right">
                        @if($add_permission)
                            <button type="submit" class="btn btn-primary float-right" id="submit">
                                <i class="fa fa-chevron-circle-right"></i> Save
                            </button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                {!! Form::close() !!}<!-- /.form end -->
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script>
        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });
        });
    </script>
@endsection <!--- footer script--->
