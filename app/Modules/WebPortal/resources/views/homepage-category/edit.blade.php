@extends('layouts.admin')
@section('header-resources')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.1/skins/content/default/content.min.css" />
    <link rel="stylesheet" href="{{ asset('assets\plugins\select2\css\select2.min.css') }}">
@endsection

@section('content')
    <style>
        .border_dashed {
            margin: 0px;
        }
    </style>
  <div class="card">
    <div class="card-header">
        <h3 class="card-title"> Edit HomePage Category  </h3>
    </div>

      {!! Form::open(['route' => 'homepage.categories.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

      <!-- /.panel-title -->
    <div class="card-body">
        <div class="row">
            <input type="hidden" name="id" value="{{ \App\Libraries\Encryption::encodeId($data->id) }}">

            <div class="card-body">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <div class="row">
                        {!! Form::label('type','Type:',['class'=>'col-md-2 required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('type', $type,$data->type, ['class' => 'form-control required']) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
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
        </div>

    </div><!-- /.box -->

    <div class="card-footer">
        <div class="float-left">
            <a href="{{ route('homepage.categories.list') }}">
                {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
            </a>
        </div>
        <div class="float-right">
            @if ($edit_permission)
                <button type="submit" class="btn btn-primary float-right" id="submit">
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
    <script src="{{ asset('assets\plugins\tinymce\tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/image_validate.js') }}"></script>


    <script>
        $(document).ready(function() {
            $("#resource_form").validate({
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

        $(function() {
            $('.error_class').hide();
            $(document).on('click', '#submit', chkSubmit);

            function chkSubmit() {
                if (tinyMCE.get('details').getContent().length == '') {
                    $('.error_class').show();
                    $('.error_class').html('Please fill out something in the details box');
                    return false;
                } else {
                    $('.error_class').hide();
                    $('.error_class').html('');
                }
            }
        });

        function previewImage(event, id, className) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById(id);
                preview.src = reader.result;
                preview.style.display = 'inline-block';
                var removePreview = document.querySelector('.' + className);
                removePreview.style.display = 'inline-block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function removeImage(img_id, remove_preview_button, input_file_id) {
            var preview = document.getElementById(img_id);
            var removePreview = document.querySelector('.' + remove_preview_button);
            preview.src = "{{ asset('images/no_image.png') }}";
            preview.style.display = 'inline-block';
            removePreview.style.display = 'none';
            var fileInput = document.getElementById(input_file_id);
            fileInput.value = '';
        }
    </script>
@endsection <!--- footer script--->
