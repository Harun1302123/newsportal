

@extends('layouts.admin')

@section('header-resources')
    <link href="{{asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

@endsection

@section('content')
    <style>
        .selected-color {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px; /* Adjust the width as needed */
            padding: 0;
        }

        .selected-color i {
            margin-right: 5px;
        }
        .border_dashed {
            margin: 0px;
        }
        .img-thumbnail
        {
            background-color: #c7c7c7;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Edit goal</h3>
                    <!-- /.card-tools -->
                </div>
                {!! Form::open(['route' => 'goals.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

                <!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" name="id" value="{{\App\Libraries\Encryption::encodeId($data->id)}}">
                    <div class="form-group {{$errors->has('title_en') ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-md-2 required-star">Title EN:</label>
                            <div class="col-md-10">
                                {!! Form::text('title_en', $data->title_en, ['class'=>'form-control required', 'placeholder'=>'Enter goal title']) !!}
                                {!! $errors->first('title_en','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{$errors->has('title_bn') ? 'has-error' : ''}}">
                        <div class="row">
                            <label class="col-md-2 required-star">Title BN:</label>
                            <div class="col-md-10">
                                {!! Form::text('title_bn', $data->title_bn, ['class'=>'form-control required', 'placeholder'=>'Enter goal title']) !!}
                                {!! $errors->first('title_bn','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="form-group {{$errors->has('description_en') ? 'has-error' : ''}}">--}}
                    {{--                        <div class="row">--}}
                    {{--                            <label class="col-md-2 ">Description EN:</label>--}}
                    {{--                            <div class="col-md-10">--}}
                    {{--                                <textarea class="form-control" style="height: 100px;" value="{{$data->description_en}}" name="description_en" id="description_en">{{$data->description_en}}</textarea>--}}
                    {{--                                {!! $errors->first('description_en','<span class="help-block">:message</span>') !!}--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    {{--                    <div class="form-group {{$errors->has('description_bn') ? 'has-error' : ''}}">--}}
                    {{--                        <div class="row">--}}
                    {{--                            <label class="col-md-2 ">Description BN:</label>--}}
                    {{--                            <div class="col-md-10">--}}
                    {{--                                <textarea class="form-control" style="height: 100px;" value="{{$data->description_bn}}" name="description_bn" id="description_bn">{{$data->description_bn}}</textarea>--}}
                    {{--                                {!! $errors->first('description_bn','<span class="help-block">:message</span>') !!}--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group {{$errors->has('colorpicker') ? 'has-error' : ''}}">--}}
{{--                                <div class="row">--}}
{{--                                    <label class="col-md-4 required-star">Goal Color</label>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            {!! Form::text('colorpicker', $data->hex_color, ['class'=>'form-control required', 'placeholder'=>'Choose goal color', 'id'=>'colorpicker']) !!}--}}
{{--                                            <div class="input-group-append colorpicker-container">--}}
{{--                                <span class="input-group-text selected-color">--}}
{{--                                    <i class="fas fa-palette"></i>--}}
{{--                                </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        {!! $errors->first('colorpicker','<span class="help-block">:message</span>') !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group {{$errors->has('order') ? 'has-error' : ''}}">--}}
{{--                                <div class="row">--}}
{{--                                    <label class="col-md-4 required-star">Order</label>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        {!! Form::number('order', $data->order, ['class'=>'form-control required']) !!}--}}
{{--                                        {!! $errors->first('order','<span class="help-block">:message</span>') !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group row">
                        {!! Form::label('bg_image', 'Image:', ['class'=>'col-md-2 required-star']) !!}

                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input {{ $errors->has('bg_image') ? ' is-invalid' : '' }}" id="bg_image" name="bg_image" {{ empty(optional($data)->bg_image) ? 'required' : '' }} value="{{ optional($data)->bg_image }}" accept="image/jpeg, image/jpg, image/png" onchange="previewImage(this, 'show_photo', '1', '301x301')">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>

                            <small class="form-text text-muted">
                                [<strong>File Format:</strong> *.jpg/ .jpeg/ .png, <strong>File-size:</strong> 1 MB, <strong>Dimension:</strong> Width 1280 X 435 Pixel]
                            </small>

                            {!! $errors->first('bg_image', '<span class="help-block">:message</span>') !!}

                            {{--Show image--}}
                            <div class="mb-1">
                                {!! CommonFunction::getImageFromURL('show_photo', optional($data)->bg_image) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <a class="btn btn-default" type="button" href="{{ route('goals.list') }}"><i
                                class="fa fa-times"></i> Close</a>
                        <div style="float: right">
                            @if($edit_permission)
                                <button class="btn btn-primary" style="float: right"><i
                                        class="fa fa-arrow-circle-o-right"></i> Update
                                </button>
                            @endif
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
@endsection
<!--content section-->

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script type="text/javascript" src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>

    <script>
        $(function () {
            $(".select2").select2();
            // Basic instantiation:
            $('#colorpicker').colorpicker();

            // Example using an event, to change the color of the icon container:
            $('#colorpicker').on('colorpickerChange', function (event) {
                var selectedColor = event.color.toString();
                $('.selected-color').css('background-color', selectedColor);
                $('.selected-color span').text(selectedColor);
                $('.selected-color i').hide();
            });

            // Set the initial selected color value
            var initialColor = {!! json_encode($data->hex_color) !!};
            $('.selected-color').css('background-color', initialColor);
            $('.selected-color span').text(initialColor);
            $('.selected-color i').hide();


        });

        $("#formId").validate({
            errorPlacement: function () {
                return false;
            }
        });
    </script>
@endsection
<!--- footer-script--->
