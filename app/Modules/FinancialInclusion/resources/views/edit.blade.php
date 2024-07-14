@php
    if (!$edit_permission) {
        die('You have no access right! Please contact with system admin if you have any query.');
    }
@endphp
@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Edit Financial Inclusion </h3>
                </div>

                {!! Form::open(['route' => 'financial_inclusions.store', 'method' => 'post', 'id' => 'form_id', 'enctype' =>'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}

                <!-- /.panel-heading -->
                <div class="card-body">
                    <input type="hidden" name="id" value="{{\App\Libraries\Encryption::encodeId($data->id)}}">
                    <div class="form-group row {{$errors->has('mef_year') ? 'has-error' : ''}}" id="user_list">
                        {!! Form::label('mef_year','Year :',['class'=>'col-md-2 control-label required-star','id'=>'mef_year']) !!}
                        <div class="col-md-10">

                            {!! Form::select('mef_year', $year,  old('mef_year', $data->mef_year), ['class' => 'form-control select2 year required']) !!}
                            {!! $errors->first('mef_year','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>


                    <div class="form-group row {{$errors->has('mef_quarter_id') ? 'has-error' : ''}}" id="user_list">
                        {!! Form::label('mef_quarter_id','Quarter :',['class'=>'col-md-2 control-label required-star','id'=>'mef_quarter_id']) !!}
                        <div class="col-md-10">
                            {!! Form::select('mef_quarter_id', $quarter, old('mef_quarter_id', $data->mef_quarter_id), ['class' => 'form-control select2 user_list required']) !!}
                            {!! $errors->first('mef_quarter_id','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>


                    <div class="form-group row {{$errors->has('organization_type_id') ? 'has-error' : ''}}"
                         id="user_list">
                        {!! Form::label('organization_type_id','Organization Type :',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('organization_type_id', $organization_types, old('organization_type_id', $data->organization_type_id), ['class' => 'form-control select2 user_list organization_type required']) !!}
                            {!! $errors->first('organization_type_id','<span class="help-block">:message</span>') !!}
                            <span class="error_class" style="color: #a80000;font-weight: bold;"></span>
                        </div>
                    </div>


                    <div id="fi_form_1" style="display: none">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Male</th>
                                <th colspan="2" class="text-center">Female</th>
                                <th colspan="2" class="text-center">Others</th>
                                <th colspan="3" class="text-center">Total</th>
                            </tr>
                            <tr>
                                <th class="text-center">Rural</th>
                                <th class="text-center">Urban</th>
                                <th class="text-center">Rural</th>
                                <th class="text-center">Urban</th>
                                <th class="text-center">Rural</th>
                                <th class="text-center">Urban</th>
                                <th class="text-center">Rural</th>
                                <th class="text-center">Urban</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{!! Form::text('male_rural', old('male_rural', $data->male_rural), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('male_urban', old('male_urban', $data->male_urban), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('female_rural', old('female_rural', $data->female_rural), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('female_urban', old('female_urban', $data->female_urban), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('others_rural', old('others_rural', $data->others_rural), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('others_urban', old('others_urban', $data->others_urban), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('total_rural', old('total_rural', $data->total_rural), ['class' => 'form-control input-md custom-input']) !!}</td>
                                <td>{!! Form::text('total_urban', old('total_urban', $data->total_urban), ['class' => 'form-control input-md custom-input']) !!}</td>
                                <td>{!! Form::text('total_a',old('total_a', $data->total), ['class' => 'form-control input-md custom-input']) !!}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="fi_form_2" style="display:none;">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">Male</th>
                                <th class="text-center">Female</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{!! Form::text('male', old('male', $data->male), ['class' => 'form-control input-md custom-input calculate-input ']) !!}</td>
                                <td>{!! Form::text('female', old('female', $data->female), ['class' => 'form-control input-md custom-input calculate-input']) !!}</td>
                                <td>{!! Form::text('total_b', old('total_b', $data->total), ['class' => 'form-control input-md custom-input']) !!}</td>
                            </tr>
                            </tbody>
                        </table>
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
                </div><!-- /.box -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('financial_inclusions.list')  }}">
                            {!! Form::button('<i class="fa fa-times"></i> Close', ['type' => 'button', 'class' => 'btn btn-default']) !!}
                        </a>
                    </div>
                    <div class="float-right">
                        @if($edit_permission)
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
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });
            $(".select2").select2();

            $(".organization_type").change(function () {
                let org_type = $(this).val();
                if (org_type === '1' || org_type === '2' || org_type === '3') {
                    $("#fi_form_2").hide();
                    $("#fi_form_1").show();
                } else if (org_type === '4' || org_type === '5' || org_type === '6' || org_type === '7') {
                    $("#fi_form_1").hide();
                    $("#fi_form_2").show();
                } else {
                    $("#fi_form_1").hide();
                    $("#fi_form_2").hide();
                }
            })


            $(".organization_type").val({{ $data->organization_type_id }}).trigger('change')


            $('.calculate-input').on('input', function () {
                console.log($(this).val())
                calculateRuralTotal();
            });

            function calculateRuralTotal() {
                let total_a = 0;
                let total_b = 0;

                let total_rural = 0;
                let total_urban = 0;

                let male_rural = $('input[name="male_rural"]').val();
                let male_urban = $('input[name="male_urban"]').val();

                let female_rural = $('input[name="female_rural"]').val();
                let female_urban = $('input[name="female_urban"]').val();

                let others_rural = $('input[name="others_rural"]').val();
                let others_urban = $('input[name="others_urban"]').val();

                let male = $('input[name="male"]').val();
                let female = $('input[name="female"]').val();

                total_rural = (parseFloat(male_rural) || 0) + (parseFloat(female_rural) || 0) + (parseFloat(others_rural) || 0);
                total_urban = (parseFloat(male_urban) || 0) + (parseFloat(female_urban) || 0) + (parseFloat(others_urban) || 0);

                total_a = (parseFloat(male_rural) || 0) + (parseFloat(female_rural) || 0) + (parseFloat(others_rural) || 0) + (parseFloat(male_urban) || 0) + (parseFloat(female_urban) || 0) + (parseFloat(others_urban) || 0);
                total_b = (parseFloat(male) || 0) + (parseFloat(female) || 0);

                $('input[name="total_rural"]').val(total_rural);
                $('input[name="total_urban"]').val(total_urban);
                $('input[name="total_a"]').val(total_a);
                $('input[name="total_b"]').val(total_b);
            }
        });
    </script>
@endsection <!--- footer script--->
