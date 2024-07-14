@extends('frontend.layouts.master')
<style>
    .nfis-cal-info{
        display: inline;
    }
    .nfis-bio-msg span{
        font-size: 20px;
	    font-weight: normal;
    }
</style>
@section('content')
    <main class="site-main-content">
        <div class="nfis-breadcrumb">
            <div class="container">
                <ul class="nfis-breadcrumb-lists">
                    <li class="nfis-bc-item bc-back-btn">
                        <a href="{{ url('/') }}">
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
                    <li class="nfis-bc-item"><a href="{{ url('/') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Biography:' : "জীবনী:" }}</li>
                </ul>
            </div>
        </div>

        <section class="gallery-sec">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="nfis-msg-block mt-4 mb-5">
                            <div class="nfis-bio-msg-item d-flex flex-row">
                                <div class="msg-item-photo">
                                    <img src="{{ asset($biography->image ?? null) }}" alt="Image not found" class=" rounded">
                                </div>
                                <div class="nfis-bio-info pt-3">
                                    <h2>{{ languageStatus() == 'en' ? ($biography->name_en??null) : ($biography->name_bn??null ) }}</h2>
                                        <p class="d-flex flex-column nfis-bio-msg pt-3">
                                            <span class="">{{ languageStatus() == 'en' ? ($biography->designation_en??null) : ($biography->designation_bn??null) }} </span>
                                            <span class="">{{ languageStatus() == 'en' ? ( $biography->organization_en??null) : ( $biography->organization_bn??null) }}</span>
                                        </p>
                                </div>
                            </div>
                    </div>
                        <div class="nfis-details-block">
                            <p>{!! languageStatus() == 'en' ? $biography->description_en??null : $biography->description_bn??null !!}</p>                        </div>
                    </div>
            </div>
        </section>
    </main>
@endsection

