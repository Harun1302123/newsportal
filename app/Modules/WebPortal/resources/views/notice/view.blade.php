@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h2 class="card-title"> {{ $data->title }} </h2><br>
            <p> {{ $data->body }}</p>
            @if($data->attachment)
                <br>
            <iframe  width="70%"
                     height="400px"
                     loading="lazy"
                     title="PDF-file" width="100%"
                     height="600px"
                     loading="lazy"
                     title="PDF-file"
                     src="{{ asset($data->attachment) }}" frameborder="0"></iframe>

            <br>
            @endif
            <br>
            <div class="d-flex justify-content-between">
                <p><b>Publish Date:</b> {{ $data->publish_at }}</p>
                <p><b>Achieve Date:</b> {{ $data->achieve_at }}</p>
            </div>
      </div>
        <div class="card-footer">

        </div>
    </div>

@endsection

@section('footer-script')
@endsection
