@extends('layouts.admin')

@section('header-resources')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<style>
    .custom-input {
        width: 100px !important;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header card-outline card-primary">
                <h5 class="card-title"><strong>{{ $card_title }}</strong></h5>
            </div>

            {!! Form::open([
            'route' => 'indicators.store',
            'method' => 'post',
            'id' => 'form_id',
            'role' => 'form',
            ]) !!}

            @php
            $benchmark = getBenchmarkData( 2022, 1, 'indicator_set_a' );
            @endphp
            <input type="hidden" name="master_id" value="{{ $benchmark ?? null }}">

            <div class="card card-info">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                            {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                            {!! Form::select('year', years(), 2010, [
                            'id' => 'year',
                            'class' => 'form-control required',
                            ]) !!}
                            {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                        </div>
                        <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                            {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                            {!! Form::select('quarter', quarters(), 1, [
                            'id' => 'quarter',
                            'class' => 'form-control required',
                            ]) !!}
                            {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                        </div>
                        <div class="form-group col-2 mr-2">
                            {!! Form::label('', 'Load Data', ['class' => 'required-star']) !!}
                            <a onclick="loadIndicatorData()" class="btn btn-info">Load Data</a>
                        </div>
                    </div>

                    <div id="load_data_div"></div>

                </div>
            </div>

            <div class="card-footer">
                <div class="float-left">
                    <a href="{{ route($list_route) }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                        Close
                    </a>
                </div>
                <div class="float-right">

                </div>
                <div class="clearfix"></div>
            </div>
            {!! form::close() !!}
        </div>
    </div>
</div>
@endsection <!--content section-->

@section('footer-script')
<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(document).ready(function() {

        // $("#form_id").validate({
        //     errorPlacement: function() {
        //         return true;
        //     }
        // });

        // toastr.warning('hello')

    });

    function loadIndicatorData() {
        let quarter = document.getElementById("quarter").value;
        let year = document.getElementById("year").value;
        if (!quarter && !year) {
            return;
        }

        $.ajax({
            url: "{{ route('indicators.indicator_total_score_form') }}",
            type: "get",
            data: {
                quarter: quarter,
                year: year,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                $("#load_data_div").html(data);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>


@endsection
