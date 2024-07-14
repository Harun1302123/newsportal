@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="card">
                    <div class="card-header card-outline card-primary">
                        <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> User role permission</h3>
                        <!-- /.card-tools -->
                    </div>

                    {!! Form::open(['route' => 'user-role-permission.store', 'method' => 'post']) !!}
                    <input type="hidden" name="encoded_role_id" value="{{ \App\Libraries\Encryption::encodeId($roleId) }}">

                    <div class="col-md-12">
                        <div class="pt-2">
                            <div class="alert section_heading1 text-white" role="alert">
                                Assign services and permissions for role: <span class="font-weight-bold"> {{ $roleName }}</span>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-body">
                                @foreach ($groupname as $key => $group)
                                    <div class="form-group col-md-12 row">
                                        {!! Form::label($key, $key, ['class' => 'col-md-12']) !!}
                                        @if (count($group) > 0)
                                            @php
                                                $group = array_chunk($group->toArray(), 3);
                                            @endphp
                                            @foreach ($group as $service_list)
                                                @foreach ($service_list as $service)
                                                    @if(in_array($service['id'], $sub_menu_services_id))
                                                        <div class="col-md-12">
                                                            <input class="" name="sub_menu[]"
                                                                   type="checkbox" value="{{ $service['name'].'_'.$service['id'] }}"
                                                                   id="{{ 'sub_menu_'.$service['id'] }}" onclick="handleSubMenu(this)" checked @if($roleId == '6' && !in_array($service['id'], [3])) disabled @endif>
                                                            <label class="" for="{{ 'sub_menu_'.$service['id'] }}"
                                                                   style="font-weight: normal;">
                                                                {{ $service['name'] }}
                                                            </label>

                                                            <div class="pl-5 d-block" id="a_e_v_{{$service['id']}}">
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("add_".$service['id'], 1, !empty($add[$service['id']]), ['class'=>'font-nm add', 'id'=>'add_'.$service['id'], 'onclick'=>'handleAddEditClick(this)', 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                    Add &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("edit_".$service['id'], 1, !empty($edit[$service['id']]), ['id'=>'edit_'.$service['id'], 'onclick'=>'handleAddEditClick(this)', 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                    Edit &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("view_".$service['id'], 1, !empty($view[$service['id']]), ['class'=>'view', 'id'=>'view_'.$service['id']]) !!}
                                                                    View &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                            {{-- {{ dd($indicatorData) }} --}}
                                                            @if($service['allow_permission_json'])
                                                                <div class="pl-5 d-block" id="indicator_data_{{$service['id']}}">
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][provide]", 1, !empty($indicatorData['provide']), ['class'=>'font-nm', 'id'=>'provide_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Provide &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][approve]", 1, !empty($indicatorData['approve']), ['id'=>'approve_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Approve &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][checker]", 1, !empty($indicatorData['checker']), ['id'=>'checker_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Checker &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="col-md-12">
                                                            <input class="" name="sub_menu[]"
                                                                   type="checkbox" value="{{ $service['name'].'_'.$service['id'] }}"
                                                                   id="{{ 'sub_menu_'.$service['id'] }}" onclick="handleSubMenu(this)" @if($roleId == '6' && !in_array($service['id'], [3])) disabled @endif>
                                                            <label class="" for="{{ 'sub_menu_'.$service['id'] }}"
                                                                   style="font-weight: normal;">
                                                                {{ $service['name'] }}
                                                            </label>

                                                            <div class="pl-5 d-none" id="a_e_v_{{$service['id']}}">
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("add_".$service['id'], 1, null, ['class'=>'font-nm add', 'id'=>'add_'.$service['id'], 'onclick'=>'handleAddEditClick(this)', 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                    Add &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("edit_".$service['id'], 1, null, ['id'=>'edit_'.$service['id'], 'onclick'=>'handleAddEditClick(this)', 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                    Edit &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                                <label style="font-weight: normal">
                                                                    {!! Form::checkbox("view_".$service['id'], 1, null, ['class'=>'view', 'id'=>'view_'.$service['id']]) !!}
                                                                    View &nbsp;&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                            @if($service['allow_permission_json'])
                                                                <div class="pl-5 d-none" id="indicator_data_{{$service['id']}}">
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][provide]", 1, null, ['class'=>'font-nm', 'id'=>'provide_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Provide &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][approve]", 1, null, ['id'=>'approve_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Approve &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                    <label style="font-weight: normal">
                                                                        {!! Form::checkbox("indicator_data[".$service['id']."][checker]", 1, null, ['id'=>'checker_'.$service['id'], 'disabled' => ($roleId == '5') ? 'disabled' : false]) !!}
                                                                        Checker &nbsp;&nbsp;&nbsp;
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" type="button" href="{{ route('user-role-permission.list') }}"><i
                            class="fa fa-times"></i> Close</a>
                    <div style="float: right">
                        <button class="btn btn-primary" style="float: right"  id="submit"><i
                                class="fa fa-arrow-circle-o-right"></i> Save
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
<!--content section-->
@section('footer-script')
    <script>
        $(document).ready(function () {
            $("#formId").validate({
                errorPlacement: function () {
                    return true;
                },
            });


        });

        function handleSubMenu(sub_menu){
            var value = $(sub_menu).val();
            var services_id = value.substring(value.lastIndexOf("_") + 1);
            var sub_menu_id = $(sub_menu).attr('id');
            var isChecked = $("#" + sub_menu_id).is(":checked");
            if (isChecked) {
                $('#a_e_v_'+services_id).addClass('d-block');
                $('#a_e_v_'+services_id).removeClass('d-none');

                $('#indicator_data_'+services_id).addClass('d-block');
                $('#indicator_data_'+services_id).removeClass('d-none');
            } else {
                $('#add_' + services_id).prop('checked', false);
                $('#edit_' + services_id).prop('checked', false);
                $('#view_' + services_id).prop('checked', false);

                $('#a_e_v_'+services_id).addClass('d-none');
                $('#a_e_v_'+services_id).removeClass('d-block');

                $('#provide_' + services_id).prop('checked', false);
                $('#approve_' + services_id).prop('checked', false);
                $('#checker_' + services_id).prop('checked', false);

                $('#indicator_data_'+services_id).addClass('d-none');
                $('#indicator_data_'+services_id).removeClass('d-block');
            }
        }

        function handleAddEditClick(checkbox) {
            var $container = $(checkbox).closest('.col-md-12');
            var $viewCheckbox = $container.find('.view');
            if (checkbox.checked) {
                $viewCheckbox.prop('checked', true);
                $viewCheckbox.prop('disabled', true);
            }else{
                $viewCheckbox.prop('disabled', false);
            }
        }
    </script>
@endsection
