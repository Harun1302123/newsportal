@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .custom-input {
            width: 100px !important;
        }
        .step-app>.step-steps>li.active {
            background-color: #007bff !important;
            color: #fff;
            border-radius: 7px;
            margin-right: 10px;
        }
        .step-app>.step-steps>li.done {
            border-radius: 7px;
            margin-right: 10px;
        }
        .step-app>.step-steps>li {
            border-radius: 7px;
            margin-right: 10px;
        }
        .step-app>.step-content{
            border:0px!important;
            padding:0px!important;

        }
        .step-app>.step-steps {
            width: 100%;
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
                    'route' => 'insurance.store',
                     'method' => 'post',
                     'id' => 'form_id',
                     'enctype' => 'multipart/form-data',
                     'files' => 'true',
                     'role' => 'form',
                 ]) !!}

                    <input type="hidden" name="master_id" value="{{ $id??null }}">

                @include('MonitoringFramework::insurance.form_partials.edit_body')

                {!! form::close() !!}
            </div>
        </div>
    </div>
@endsection <!--content section-->

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/step-js/jquery-steps.min.css') }}">
    <script src="{{ asset('plugins/step-js/jquery-steps.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                }
            });

            // toastr.warning('hello')

        });
    </script>
    <x-plugin.confirmation-box/>

@endsection
