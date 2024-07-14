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
    
@endsection <!--content section-->

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                }
            });
        });
    </script>

@endsection
