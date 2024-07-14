@extends('frontend.layouts.master')

@section('style')
    <style>
        .stakeholders-item:hover a{
            color: #000000;
            background-size: 0 1.5px;
        }
        .stakeholders-item a:hover{
            color: #1C9D50;
            background-size: 100% 1.5px;
        }
    </style>
@endsection

@section('content')
    <main class="site-main-content page-height">
        <div class="container">
            <div class="nfis-breadcrumb">
                <ul class="nfis-breadcrumb-lists">
                    <li class="nfis-bc-item bc-back-btn">
                        <a href="{{ route('frontend.home') }}">
                                <span class="bc-back-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <path opacity="0.4" d="M6.59015 11.3925C3.46604 11.3925 0.925408 8.85126 0.925408 5.72773C0.925408 2.60419 3.46604 0.0629883 6.59015 0.0629883C9.71368 0.0629883 12.2549 2.60419 12.2549 5.72773C12.2549 8.85126 9.71368 11.3925 6.59015 11.3925" fill="white"></path>
                                        <path d="M7.40704 8.11853C7.29884 8.11853 7.19008 8.07718 7.10738 7.99448L5.13208 6.02881C5.05221 5.94894 5.00746 5.84074 5.00746 5.72745C5.00746 5.61472 5.05221 5.50652 5.13208 5.42665L7.10738 3.45985C7.27335 3.29444 7.54186 3.29444 7.70784 3.46099C7.87325 3.62753 7.87268 3.89661 7.70671 4.06202L6.03391 5.72745L7.70671 7.39288C7.87268 7.55829 7.87325 7.8268 7.70784 7.99334C7.62513 8.07718 7.5158 8.11853 7.40704 8.11853" fill="white"></path>
                                    </svg>
                                </span>
                        </a>
                    </li>
                    <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Stakeholders' : "স্টেকহোল্ডারস" }}</li>
                </ul>
            </div>

            <div class="nfis-page-heading">
                <h2>{{ languageStatus() == 'en' ? 'Stakeholders' : "স্টেকহোল্ডারস" }}</h2>
            </div>
        </div>


        <div class="nfis-page-content">
            <div class="container">
                <div class="nsc-page-content nfis-content-container" style="padding: 10px 20px;">
                    <div class="stakeholders-sec-content">
                        <div class="row">
                            @foreach($stakeholders as $key => $value)
                                <div class="stakeholders-item">
                                    <h4 class="font-weight-bold"><a href="{{ $value['url'] }}">{{ languageStatus() == 'en' ? ($value['name_en']??null) : ($value['name_bn']??null)}}</a></h4>

                                    <div class="row">
                                        @if(count($value['organizations'])>1)
                                                    @foreach($value['organizations'] as $data)
                                                        <div class="col-md-4">
                                                            <a href="{{ $data['organization_url'] }}">
                                                                {{ languageStatus() == 'en' ? ($data['organization_name_en']??null) : ($data['organization_name_bn']??null)}}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                            @endif
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
