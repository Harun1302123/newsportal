@php
    // dd(1111111)
@endphp

@extends("frontend.partials.email-template")

@section('title')
    {!! $header !!}
@endsection

@section("content")
    {!! $param !!}
@endsection 