{!! Form::open(array('url' => url('/settings/document-v2/update/' . $encoded_doc_id),'method' => 'post', 'class' => 'form-horizontal smart-form','id'=>'documentEditForm',
        'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form')) !!}

<div class="modal-header">

    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-stop"></i> Edit document</h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
    </button>
</div>

<div class="modal-body">
    <div class="errorMsg alert alert-danger alert-dismissible hidden">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    </div>
    <div class="successMsg alert alert-success alert-dismissible hidden">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="form-group col-md-12 row">
                {!! Form::label('name','Document name: ',['class'=>'col-md-4  required-star']) !!}
                <div class="col-md-8">
                    {!! Form::text('name', $document_info->name, ['class'=>'form-control required input-sm','placeholder'=>'Document name']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-11">
            <div class="form-group col-md-12 row">
                {!! Form::label('min_size','Minimum size(KB): ',['class'=>'col-md-3  required-star']) !!}
                <div class="col-md-9">
                    <div class="input-group">
                        {!! Form::number('min_size', $document_info->min_size, ['class'=>'form-control required input-sm','placeholder'=>'Minimum size', 'id'=>'min_size', 'readonly'=>true]) !!}
                        <span class="btn input-group-addon" type="button" onclick="editSize(this)">
                            <span class="fa fa-edit"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-11">
            <div class="form-group col-md-12 row">
                {!! Form::label('max_size','Maximum size(KB): ',['class'=>'col-md-3  required-star']) !!}
                <div class="col-md-9">
                    <div class="input-group">
                        {!! Form::number('max_size', $document_info->max_size, ['class'=>'form-control required input-sm','placeholder'=>'Maximum size', 'id'=>'max_size', 'readonly'=>true]) !!}
                        <span class="btn input-group-addon" type="button" onclick="editSize(this)">
                            <span class="fa fa-edit"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="form-group col-md-12 row">
                {!! Form::label('status','Status',['class'=>'text-left required-star col-md-4']) !!}
                <div class="col-md-8">
                    <label class="radio-inline">
                        {!! Form::radio('status', 1, ($document_info->status == '1' ? true : false), ['class'=>'required', 'id' => 'doc_active_status']) !!}
                        Active
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('status', 0, ($document_info->status == '0' ? true : false), ['class'=>'required', 'id' => 'doc_inactive_status']) !!}
                        In-active
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer" style="display: block;">
    <div class="float-left">
        {!! Form::button('<i class="fa fa-times"></i> Close', array('type' => 'button', 'class' => 'btn btn-danger', 'data-dismiss' => 'modal')) !!}
    </div>
    <div class="float-right">
        @if(ACL::getAccessRight('settings','A'))
            <button type="submit" class="btn btn-primary" id="block_create_btn" name="actionBtn" value="draft">
                <i class="fa fa-chevron-circle-right"></i> Save
            </button>
        @endif
    </div>
    <div class="clearfix"></div>
</div>
{!! Form::close() !!}


<script>
    $(document).ready(function () {
        $("#documentEditForm").validate({
            errorPlacement: function () {
                return true;
            },
            submitHandler: formSubmit
        });

        const form = $("#documentEditForm"); //Get Form ID
        const url = form.attr("action"); //Get Form action
        const type = form.attr("method"); //get form's data send method
        const info_err = $('.errorMsg'); //get error message div
        const info_suc = $('.successMsg'); //get success message div

        //============Ajax Setup===========//
        function formSubmit() {
            $.ajax({
                type: type,
                url: url,
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function (msg) {
                    console.log("before send");
                    $("#block_create_btn").html('<i class="fa fa-cog fa-spin"></i> Loading...');
                    $("#block_create_btn").prop('disabled', true); // disable button
                },
                success: function (data) {
                    //==========validation error===========//
                    if (data.success == false) {
                        info_err.hide().empty();
                        $.each(data.error, function (index, error) {
                            info_err.removeClass('hidden').append('<li>' + error + '</li>');
                        });
                        info_err.slideDown('slow');
                        info_err.delay(2000).slideUp(1000, function () {
                            $("#block_create_btn").html('Submit');
                            $("#block_create_btn").prop('disabled', false);
                        });
                    }
                    //==========if data is saved=============//
                    if (data.success == true) {
                        info_suc.hide().empty();
                        info_suc.removeClass('hidden').html(data.status);
                        info_suc.slideDown('slow');
                        info_suc.delay(2000).slideUp(800, function () {
                            window.location.href = data.link;
                        });
                        form.trigger("reset");

                    }
                    //=========if data already submitted===========//
                    if (data.error == true) {
                        info_err.hide().empty();
                        info_err.removeClass('hidden').html(data.status);
                        info_err.slideDown('slow');
                        info_err.delay(1000).slideUp(800, function () {
                            $("#block_create_btn").html('Submit');
                            $("#block_create_btn").prop('disabled', false);
                        });
                    }
                },
                error: function (data) {
                    const errors = data.responseJSON;
                    $("#block_create_btn").prop('disabled', false);
                    alert('Sorry, an unknown Error has been occured! Please try again later.');
                }
            });
            return false;
        }
    });

    function editSize(e){
        if ($(e).children('span').hasClass('fa fa-edit')){
            $(e).children('span').removeClass('fa fa-edit').addClass('fa fa-ban');
            $(e).prev('input').attr('readonly', false);
        }else {
            $(e).children('span').removeClass('fa fa-ban').addClass('fa fa-edit');
            $(e).prev('input').attr('readonly', true);
        }

    }
</script>
