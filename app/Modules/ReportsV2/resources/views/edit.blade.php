@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('content')
<div class="col-lg-12">

<!--
    {!! Session::has('success') ? '<div class="alert alert-success alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("success") .'</div>' : '' !!}
    {!! Session::has('error') ? '<div class="alert alert-danger alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("error") .'</div>' : '' !!}
-->

    <div class="card card-magenta border border-magenta">
        <div class="card-header">
           Report Edit
        </div>
        <!-- /.panel-heading -->
        <div class="card-body">

            {!! Form::open(['url' => '/reportv2/update/'.Encryption::encodeId($report_data->report_id), 'method' => 'patch', 'id' => 'report_form',
            'class' => 'form report_form', 'role' => 'form']) !!}
            <div class="row">
    <div class="col-sm-8">
            <!-- text input -->
            <div class="form-group {{$errors->has('report_title') ? 'has-error' : ''}}">
                {!! Form::label('report_title','Report Title',  ['class'=>'required-star']) !!}
                {!! Form::text('report_title',$report_data->report_title,['class'=>'form-control bnEng required report_title']) !!}
                {!! $errors->first('report_title','<span class="help-block">:message</span>') !!}
            </div>

        <div class="form-group {{$errors->has('report_category') ? 'has-error' : ''}}">
            {!! Form::label('report_category','Report Category', ['class'=>'']) !!}
            {!! Form::text('report_category', $report_data->category_name,['class'=>'form-control bnEng report_category','placeholder'=>'Enter report category...', 'id'=>'tags']) !!}
            <input type="hidden" id="tags_value" name="tags_value" value="{{ $report_data->category_id }}">
            {!! $errors->first('report_category','<span class="help-block">:message</span>') !!}
        </div>

            <!-- radio -->
            <div class="form-group">
                <div class="radio">
                    <label>
                        {!! Form::radio('status', '1', $report_data->status== 1 ? true : false) !!}
                        Published
                    </label>
                    <label>
                        {!! Form::radio('status', '0', $report_data->status== 0 ? true : false) !!}
                        Unpublished
                    </label>
                </div>
            </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group {{$errors->has('selection_type') ? 'has-error' : ''}}">
        {!! Form::label('selection_type','Permission based on :', ['class'=>'required-star']) !!}
        {!! Form::select('selection_type',[''=>'Select One','1'=>'User Specific','2'=>'User Type Specific'],$selection_type,['class' => 'form-control required limitedNumbSelect2 user_id']) !!}
        {!! $errors->first('selection_type','<span class="help-block">:message</span>') !!}
    </div>
            <fieldset style=""; id="permission_data">
                <?php $type2=($selection_type==1?'display:none;':'');?>
                <?php $type1=($selection_type==2?'display:none;':'');?>

                <fieldset class="scheduler-border" style="padding: 0px; {{$type2}}" id="type_specific_data">
                    <legend class="scheduler-border" style="color: gray;margin-bottom:3px;">Permission to user-type</legend>
                    <div class="form-group {{$errors->has('user_id') ? 'has-error' : ''}}">
                        {!! Form::label('user_id','Please select user type(s)') !!}
                        {!! Form::select('user_id[]', $usersList,$selected_user_type,['class' => 'form-control required user_id','multiple']) !!}
                        {!! $errors->first('user_id','<span class="help-block">:message</span>') !!}
                    </div>
                </fieldset>

                <fieldset class="scheduler-border" style="padding: 0px; {{$type1}}" id="user_specific_data" >
                    <legend class="scheduler-border" style="color: gray;margin-bottom:3px;">Permission to specific users</legend>
                    <div class="form-group {{$errors->has('user_type') ? 'has-error' : ''}}">
                        {!! Form::label('user_type','Please select user type(s)') !!}
                        {!! Form::select('user_type[]', $usersList,$selected_user_type,['class' => 'form-control  required user_id','multiple','id'=>'user_types']) !!}
                        {!! $errors->first('user_type','<span class="help-block">:message</span>') !!}
                    </div>
                    {!! Form::label('users','Please select user(s)') !!}
                    <select id="mySelect2" name="users[]" class="city form-control limitedNumbSelect2" required="true" data-placeholder="Select users" style="width: 100%;" multiple="multiple">
                        @foreach($selected_users as $user)
                            @if(in_array( $user->id, $select))
                                <option value="{{ $user->id }}" selected="true">{{ $user->user_full_name }}{{'('.$user->user_email.')'}}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->user_full_name }}({{$user->user_email}}))</option>
                            @endif
                        @endforeach
                    </select>
                </fieldset>

            </fieldset>
    </div>
            </div>

    <div class="col-sm-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab_1" aria-expanded="true"><i
                                class="fa fa-code"></i> SQL</a></li>
                    <li class="results_tab nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_2" aria-expanded="false"><i
                                class="fa fa-table"></i> Results</a></li>
                    <li class="db_tables nav-item"><a class="nav-link" data-toggle="tab" href="#tab_3" aria-expanded="false"><i
                                class="fa fa-university"></i> Database objects</a></li>
                    <li class="help nav-item"><a class="nav-link" data-toggle="tab" href="#tab_4" aria-expanded="false"><i
                                class="fa fa-question-circle"></i> Help</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab_1" class="tab-pane active">
                        <!-- textarea -->
                        <div class="form-group {{$errors->has('report_para1') ? 'has-error' : ''}}">
                            {!! Form::textarea('report_para1', Encryption::dataDecode($report_data->report_para1), ['class'=>'sql form-control well fa-code-fork']) !!}
                            {!! $errors->first('report_para1','<span class="help-block">:message</span>') !!}
                        </div>
                    </div><!-- /.tab-pane -->

                    <div id="tab_2" class="tab-pane">
                        <div class="results">
                            <br />
                            <br />
                            Please click on Verify button to run the SQL.
                            <br />
                            <br />
                            <br />
                        </div>
                    </div><!-- /.tab-pane -->
                    <div id="tab_3" class="tab-pane">
                        <div class="db_fields">
                            <br />
                            Please click on Show Tables button to run the SQL.
                            <br />
                            you can run SELECT statement to generate a report.
                            <br />SysAdmin can execute SHOW, DESC, EXPLAIN statement!
                            <br />
                            <br />
                            <br />
                        </div>
                    </div><!-- /.tab-pane -->
                    <div id="tab_4" class="tab-pane">
                        <div class="help">
                            @include('ReportsV2::help')
                        </div>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div>
    </div>
            <div class="col-md-12">
                {!! \App\Libraries\CommonFunction::showAuditLog($report_data->updated_at, $report_data->updated_by) !!}
            </div>
            {!! Form::hidden('redirect_to_new',0,['class'=>'form-control redirect_to_new']) !!}
            <div class="form-group">
                @if($edit_permission)
                {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'button', 'value'=> 'save', 'class' => 'btn btn-success save')) !!}
                {!! Form::button('<i class="fa fa-credit-card"></i> Save & Run', array('type' => 'button', 'value'=> 'save_new', 'class' => 'btn btn-warning save')) !!}
                @endif
                <a href="/reports">{!! Form::button('<i class="fa fa-times"></i> Close', array('type' => 'button', 'class' => 'btn btn-danger')) !!}</a>
                @if($add_permission)
                {!! Form::button('<i class="fa fa-files-o"></i> Save as new',  array('type' => 'button', 'value'=>'save_as_new', 'class' => 'btn btn-primary save')) !!}
                @endif

                <span class="pull-right">
                    @if($add_permission)
                    <button class="btn btn-sm btn-primary" id="verifyBtn" type="button">
                        <i class="fa fa-check"></i>
                        Verify
                    </button>
                    <button class="btn btn-sm btn-primary" id="showTables" type="button">
                        <i class="fa fa-list"></i> Show Database
                    </button>
                    @endif
                </span>
            </div>
            {!! Form::close() !!}
        </div><!-- /.box-body -->
    </div>
</div>
@endsection


@section('footer-script')
    <script type="text/javascript" src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script><script>
    $(document).ready(
            function () {
                $('.save').click(function () {
                    switch ($(this).val()) {
                        case 'save_as_new' :
                            $('.report_title').val($('.report_title').val() + "-{{ Carbon\Carbon::now() }}");
                            $('.report_form').attr('action', "{!! URL::to('/reportv2/store') !!}");
                            break;
                        case 'save_new':
                            $('.redirect_to_new').val(1);
                            break;
                        default:
                    }
                    $('.report_form').submit();
                });
                $(".limitedNumbSelect2").select2({
                    //maximumSelectionLength: 1
                });

                $('#verifyBtn').click(function () {
                    var sql = $('.sql').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '/reportv2/verify',
                        type: 'POST',
                        data: {sql: sql, _token: _token},
                        dataType: 'text',
                        success: function (data) {
                            $('.results').html(data);
                            $('.results_tab a').trigger('click');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('.results').html(jqXHR.responseText);
                            $('.results_tab a').trigger('click');
                        }
                    });
                });
                $('#user_types').on('change',function () {
                    var types = $('#user_types').val();
                    var _token = $('input[name="_token"]').val();
                    var userSelect = $('#mySelect2');
                    $.ajax({
                        url: '/reportv2/getuserbytype',
                        type: 'GET',
                        data: {types: types},
                        success: function (data) {
                            var option = '';
                            $.each(data, function (id, value) {
                                option += '<option value="' + value.id + '">' + value.user_full_name+'('+value.user_email +')</option>';
                            });

                            $("#mySelect2").html(option);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('.results').html(jqXHR.responseText);
                            $('.results_tab a').trigger('click');
                        }
                    });
                });
                $('#selection_type').on('change',function () {

                    var types = $('#selection_type').val();
                    ;
                    if (types==2){
                        $('#user_type').find('option:selected').remove().end();
                        $('#mySelect2').find('option:selected').remove().end();
                        $('#permission_data').hide();
                        $('#user_specific_data').hide();
                        $('#type_specific_data').show();
                        $('#permission_data').show();

                    }else if(types==1){
                        $('#user_id').find('option:selected').remove().end();
                        $('#permission_data').hide();
                        $('#type_specific_data').hide();
                        $('#user_specific_data').show();
                        $('#permission_data').show();
                    }else{
                        $('#permission_data').hide();
                    }

                });

                $('#showTables').click(function () {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '/reportv2/tables',
                        type: 'GET',
                        data: {_token: _token},
                        dataType: 'text',
                        success: function (data) {
                            $('.db_fields').html(data);
                            $('.db_tables a').trigger('click');
                        }
                    });
                });
            });

    $(document).ready(
            function () {
                $("#report_form").validate({
                    errorPlacement: function () {
                        return false;
                    }
                });
            });
</script>
    <script>
        $( function() {

            $("#tags").autocomplete({
                minLength: 3,
                source: function(request, response) {
                    $.ajax({
                        url: "{{url('reportv2/get-report-category')}}",
                        data: {
                            term : request.term
                        },
                        dataType: "json",
                        success: function(data){
                            var resp = $.map(data,function(obj){
                                return {
                                    label: obj.category_name,
                                    value: obj.id
                                };
                            });

                            response(resp);
                        }
                    });
                },
                select: function (event, ui) {
                    $("#tags").val(ui.item.label); // display the selected text
                    $("#tags_value").val(ui.item.value); // save selected id to hidden input
                    return false;
                }

            });
        } );


    </script>
@endsection
