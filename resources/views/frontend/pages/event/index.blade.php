@extends('frontend.layouts.master')

@section('content')
    <main class="site-main-content">
        <div class="nfis-breadcrumb">
            <div class="container">
                <ul class="nfis-breadcrumb-lists">
                    <li class="nfis-bc-item bc-back-btn">
                        <a href="{{ route('frontend.home') }}">
                            <span class="bc-back-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"
                                    fill="none">
                                    <path opacity="0.4"
                                        d="M6.59015 11.3925C3.46604 11.3925 0.925408 8.85126 0.925408 5.72773C0.925408 2.60419 3.46604 0.0629883 6.59015 0.0629883C9.71368 0.0629883 12.2549 2.60419 12.2549 5.72773C12.2549 8.85126 9.71368 11.3925 6.59015 11.3925"
                                        fill="white"></path>
                                    <path
                                        d="M7.40704 8.11853C7.29884 8.11853 7.19008 8.07718 7.10738 7.99448L5.13208 6.02881C5.05221 5.94894 5.00746 5.84074 5.00746 5.72745C5.00746 5.61472 5.05221 5.50652 5.13208 5.42665L7.10738 3.45985C7.27335 3.29444 7.54186 3.29444 7.70784 3.46099C7.87325 3.62753 7.87268 3.89661 7.70671 4.06202L6.03391 5.72745L7.70671 7.39288C7.87268 7.55829 7.87325 7.8268 7.70784 7.99334C7.62513 8.07718 7.5158 8.11853 7.40704 8.11853"
                                        fill="white"></path>
                                </svg>
                            </span>
                        </a>
                    </li>
                    <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Event' : "ইভেন্ট" }}</li>
                </ul>
            </div>
        </div>
        <section class="gallery-sec">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="page-title">
                        <h2>{{ languageStatus() == 'en' ? 'Event' : "ইভেন্ট" }}</h2>
                    </div>

                    <div class="gallery-content" id="galleryContent">
                        <div class="row">
                            @foreach ($event as $single_event)
                            <div class="col-xl-3 col-lg-4 col-md-6 gallery-col">
                                <div class="nfis-news-item">
                                    <div class="news-item-img" style="background-image: url({{ asset(CommonFunction::setImageOrDefault($single_event->image??null)) }});" onerror="this.src=`{{asset('images/no_image.png')}}`"></div>
                                    <div class="news-item-desc">
                                        <span class="date-meta">{{ !empty($single_event->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($single_event->updated_at))) : date('d M, Y', strtotime($single_event->updated_at)) : null }}</span>
                                        <h5>{{ languageStatus() == 'en' ? Str::limit($single_event->heading_en??null, 80) : Str::limit($single_event->heading_bn??null, 80) }}</h5>
                                        <p>{{ languageStatus() == 'en' ? (Str::limit(strip_tags($single_event->details_en), 80)??null) :(Str::limit(strip_tags($single_event->details_bn),80)??null) }}</p>
                                    </div>
                                    <div class="sec-seemore-group">
                                        <a class="nfis-sec-btn" href="{{ route('frontend.event.show',['id' => Encryption::encodeId($single_event->id)]) }}">{{ languageStatus() == 'en' ? 'Details' : "বিস্তারিত" }} <span class="icon-btn-arrow-clr"></span></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

{{--                        <div class="nfis-pagination">--}}
{{--                            <div class="d-flex justify-content-center my-5">--}}
{{--                                {!! $article->links() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
        </section>

    </main>
@endsection

@section('script')

@endsection