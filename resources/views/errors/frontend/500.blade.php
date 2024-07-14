@extends('frontend.layouts.master')

@section('content')
    <main class="site-main-content page-height bg-light-green">
        <div class="nfis-post-content">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="col-md-12 text-center">
                        <h2 class="display-1 headline text-danger">500</h2>
                        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
                        <a href="{{ route('frontend.home') }}" class="btn btn-link">Back to Home</a>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection

@section('script')
@endsection
