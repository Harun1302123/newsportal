@extends('layouts.admin')
@section('header-resources')
    <link rel="stylesheet" href="{{ asset("assets\plugins\select2\css\select2.min.css") }}">
@endsection
@section('content')
   <style>
    .border_dashed {
    margin: 0px;
    }
    </style>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contact Setting</h3>
                </div>

            {!! Form::open(array('url' => url('/contact-setting/update'),'method' => 'post', 'id' => 'form_id',
                'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form')) !!}
            <!-- /.panel-title -->
                <div class="card-body">
                    <input type="hidden" name="id" value="{{\App\Libraries\Encryption::encodeId($data->id)}}">

                    <div class="card card-cyan border border-magenta">
                        <div class="card-header section_heading1" style="padding:0.35rem 1.25rem">
                            <h3 class="card-title pt-2 pb-2"> General Settings </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 ">
                                    <div class="row">
                                    {!! Form::label('manage_by','Manage By:',['class'=>'col-md-2 control-label']) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('manage_by', $data->manage_by, ['class' => 'form-control']) !!}
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 ">
                                    <div class="row">
                                        {!! Form::label('associate','Associate:',['class'=>'col-md-2 control-label']) !!}
                                        <div class="col-md-10">
                                            {!! Form::text('associate', $data->associate, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 ">
                                    <div class="row">
                                        {!! Form::label('at_a_glance_link','At a glance link:',['class'=>'col-md-2 control-label']) !!}
                                        <div class="col-md-10">
                                            {!! Form::text('at_a_glance_link', $data->at_a_glance_link, ['class' => 'form-control', 'placeholder'=>'https://www.youtube.com/embed/QlYGrcrC4q0']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 ">
                                    <div class="row">
                                        {!! Form::label('support_link','Support Link:',['class'=>'col-md-2 control-label']) !!}
                                        <div class="col-md-10">
                                            {!! Form::text('support_link', $data->support_link, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-md-12">
                                    {!! Form::label('logo', 'Logo:', ['class'=>'col-md-2 required-star']) !!}

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}" id="image" name="logo" {{ empty(optional($data)->logo) ? 'required' : '' }} value="{{ optional($data)->image }}" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(this, 'show_photo', '1', '')">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                        </div>

                                        <small class="form-text text-muted">
                                            [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB <strong>Dimension:</strong> Width 315 X 60 Pixel]
                                        </small>

                                        {!! $errors->first('logo', '<span class="help-block">:message</span>') !!}

                                        {{--Show image--}}
                                        <div class="mb-1">
                                            {!! CommonFunction::getImageFromURL('show_photo', optional($data)->logo) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-cyan border border-magenta">
                        <div class="card-header section_heading1" style="padding:0.35rem 1.25rem">
                            <h3 class="card-title pt-2 pb-2"> Contact Information </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_name_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                    {!! Form::label('contact_person_one_name_en','Contact Person One Name EN:',['class'=>'col-md-4 control-label']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('contact_person_one_name_en', $data->contact_person_one_name_en, ['class' => 'form-control']) !!}
                                        {!! $errors->first('contact_person_one_name_en','<span class="help-block">:message</span>') !!}
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_name_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_one_name_bn','Contact Person One Name BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_one_name_bn', $data->contact_person_one_name_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_one_name_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_designation_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_one_designation_en','Contact Person One Designation EN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_one_designation_en', $data->contact_person_one_designation_en, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_one_designation_en','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_designation_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_one_designation_bn','Contact Person One Designation BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_one_designation_bn', $data->contact_person_one_designation_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_one_designation_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_phone') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_one_phone','Contact Person One Phone:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_one_phone', $data->contact_person_one_phone, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_one_phone','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_one_email') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_one_email','Contact Person One Email:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_one_email', $data->contact_person_one_email, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_one_email','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_name_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_name_en','Contact Person two Name EN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_name_en', $data->contact_person_two_name_en, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_name_en','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_name_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_name_bn','Contact Person two Name BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_name_bn', $data->contact_person_two_name_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_name_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_designation_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_designation_en','Contact Person two Designation EN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_designation_en', $data->contact_person_two_designation_en, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_designation_en','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_designation_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_designation_bn','Contact Person two Designation BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_designation_bn', $data->contact_person_two_designation_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_designation_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_phone') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_phone','Contact Person Two Phone:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_phone', $data->contact_person_two_phone, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_phone','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_two_email') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_two_email','Contact Person Two Email:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_two_email', $data->contact_person_two_email, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_two_email','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_name_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_name_en','Contact Person Three Name EN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_name_en', $data->contact_person_three_name_en, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_name_en','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_name_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_name_bn','Contact Person Three Name BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_name_bn', $data->contact_person_three_name_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_name_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_designation_en') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_designation_en','Contact Person Three Designation EN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_designation_en', $data->contact_person_three_designation_en, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_designation_en','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_designation_bn') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_designation_bn','Contact Person Three Designation BN:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_designation_bn', $data->contact_person_three_designation_bn, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_designation_bn','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_phone') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_phone','Contact Person Three Phone:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_phone', $data->contact_person_three_phone, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_phone','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{$errors->has('contact_person_three_email') ? 'has-error' : ''}}">
                                    <div class="row">
                                        {!! Form::label('contact_person_three_email','Contact Person Three Email:',['class'=>'col-md-4 control-label']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('contact_person_three_email', $data->contact_person_three_email, ['class' => 'form-control']) !!}
                                            {!! $errors->first('contact_person_three_email','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>






                            </div>
                        </div>
                    </div>
                    </div>







                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ url('/contact-setting/list') }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', array('type' => 'button', 'class' => 'btn btn-default')) !!}
                        </a>
                    </div>
                    <div class="float-right">
                        @if($edit_permission)
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fa fa-chevron-circle-right"></i> Update
                            </button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            {!! Form::close() !!}<!-- /.form end -->
            </div>
@endsection

@section('footer-script')
    <script src="{{asset('assets\plugins\select2\js\select2.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });
            $(".select2").select2();
        });
    </script>
@endsection <!--- footer script--->
