@extends('frontend.layouts.master')

@section('style')
    <link rel="stylesheet"  href="{{ asset('plugins/OwlCarousel/owl-carousel.css') }}" />
@endsection

@section('content')
    @include('frontend.pages.home.banner')
    @include('frontend.pages.home.financial_inclusion')
    @include('frontend.pages.home.strategic_goals')
    @include('frontend.pages.home.m_and_e_framework')
    @include('frontend.pages.home.news')
    @include('frontend.pages.home.e_participation')
    @include('frontend.pages.home.events')
    @include('frontend.pages.home.video_gallery')
    @include('frontend.pages.home.photo_gallery')
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/d3/d3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/OwlCarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/countdown/countdown.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ring-main.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            let photoSlider = $(".nfisPhotoSlider");
            photoSlider.owlCarousel({
                autoplay: false,
                autoplayTimeout: 7000,
                autoplayHoverPause: true,
                items: 4,
                loop: true,
                center: false,
                margin: 20,
                smartSpeed: 800,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    767: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1440: {
                        items: 4
                    }
                }
            });

            let videoSlider = $(".nfisVideoSlider");
            videoSlider.owlCarousel({
                autoplay: false,
                autoplayTimeout: 7000,
                autoplayHoverPause: true,
                items: 3,
                loop: true,
                center: false,
                margin: 20,
                smartSpeed: 800,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    767: {
                        items: 2,
                        margin: 20,
                    },
                    992: {
                        items: 3,
                        margin: 30,
                    },
                    1280: {
                        margin: 50,
                    },
                }
            });

            startCountdown('event', document.getElementById("event_date_time").textContent)
        });

    </script>

    <script>

        function portalPublishScoreAction() {

            $.ajax({
                url: "{{ route('portal_publish_score') }}",
                type: "get",
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
                    if (data.interpretation) {
                        $("#publish_score_data").html('Status : ' + data.interpretation);
                        $("#publish_score").html('Score : ' + data.integratedIndex);
                        $("#publish_status").html('Status : ' + data.interpretation);
                    }
                },
                error: function error(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        setTimeout(portalPublishScoreAction(), 0);


    </script>
@endsection
