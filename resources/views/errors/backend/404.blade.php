@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
    <link rel="stylesheet"  href="{{ asset('plugins/simple-calendar/simple-calendar.css') }}" />
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 text-center">

            <h2 class="display-1 headline text-warning"> 404</h2>
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
        </div>
    </div>
@endsection

@section('footer-script')
@endsection
