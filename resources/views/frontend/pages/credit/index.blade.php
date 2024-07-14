@extends('frontend.layouts.master')
<style>
    .trapezoid {
        border-bottom: 50px solid #588DBE;
        border-left: 25px solid white;
        border-right: 25px solid white;
        height: 0;
        width: 370px;
        box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.05);
    }

    .trapezoid-2 {
        border-bottom: 50px solid #588DBE;
        border-left: 25px solid white;
        border-right: 25px solid white;
        height: 0;
        width: 600px;
        box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.05);
    }
    .trapezoid-3{
        border-bottom: 50px solid #588DBE;
        border-left: 25px solid white;
        border-right: 25px solid white;
        height: 0;
        width: 400px;
        box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.05);
    }
    .a2i-header {
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }








    .credit-card-item:hover {
        background: #588DBE;
    }
    .credit-card-item .line
    {
        width: 80px;
        height: 2px;
        background: #2878C2;
        display: inline-block;
    }


    /*.credit-card:hover .credit-title,*/
    /*.credit-card:hover .credit-position,*/
    /*.credit-card:hover .credit-details {*/
    /*    color: #fff;*/
    /*    !* Change text color on hover *!*/
    /*}*/




    .credit-card {
        transition: background-color 0.3s ease;
        /* Smooth transition for background color */
    }

    .credit-card .line {
        transition: all 0.3s ease;
    }

    /*.credit-card:hover .line {*/
    /*    content: url('images/Line2.svg');*/
    /*}*/
</style>
@section('content')
    <div class="main-page-content">
        <div class="container">
            <div class="nfis-breadcrumb">
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
                    <li class="nfis-bc-item"><a
                            href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : 'হোম' }}</a></li>

                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Credit' : 'ক্রেডিট' }}</li>
                </ul>
            </div>
            <div class="nfis-page-heading">
                <h2>
                    {{ languageStatus() == 'en' ? 'NFIS tracker credit list' : '' }}
                </h2>
            </div>

            <div class="container mb-4">
                <div class="trapezoid  mx-auto d-block">
                    <h4 class="text-center pt-2 text-white a2i-header"> {{ languageStatus() == 'en' ? 'Aspire to Innovate (a2i)' : 'উদ্ভাবনের আকাঙ্খা (এটুআই)' }}</h4>
                </div>
                <div class="mt-4">
                        <div class="credit-card d-flex">
                            @foreach($a2i_team as $team)
                                <div class="credit-card-item card border-0 py-2">
                                    <div class="card-img" style="background-image: url('/{{ \App\Libraries\CommonFunction::setImageOrDefault($team->image) }}')"></div>
                                    <div class="card-desc">
                                        <h5 class=" credit-title">{{ languageStatus() == 'en' ? ($team->name_en ??null) : ( $team->name_bn ??null) }}</h5>
                                        <p class="card-text credit-position">{{ languageStatus() == 'en' ? ($team->designation_en ??null) : ($team->designation_bn ??null) }}</p>
                                        <span class="line"></span>
                                        <p class="card-text credit-details mt-3">{{ languageStatus() == 'en' ? ($team->details_en ??null) : ( $team->details_bn ??null) }}</p>
    
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>

                <div class="trapezoid-2 mx-auto d-block mt-4">
                    <h4 class="text-center pt-2 text-white a2i-header">{{ languageStatus() == 'en' ? 'NFIS Tracker Development & Maintenance Team' : 'এনএফআইএস ট্র্যাকার উন্নয়ন ও রক্ষণাবেক্ষণ দল' }}</h4>
                </div>

                <div class="mt-4">
                    <div class="credit-card d-flex">
                        <h3 class="col-md-8 text-center">
                            {{ languageStatus() == 'en' ? 'NFIS Administrative Unit (NAU)' : 'এনএফআইএস প্রশাসনিক ইউনিট (এনএইউ)' }}, 
                            <br>
                            {{ languageStatus() == 'en' ? ' Bangladesh Bank
                            Information & Communication Technology Department
                            (ICTD), Bangladesh Bank' : 'বাংলাদেশ ব্যাংক তথ্য ও যোগাযোগ প্রযুক্তি বিভাগ (ICTD), বাংলাদেশ ব্যাংক' }}
                           
                        </h3>

                       {{-- @foreach($dev_maintenance_team as $team)
                           <div class="credit-card-item card border-0 py-2">
                               <div class="card-img" style="background-image: url('/{{ \App\Libraries\CommonFunction::setImageOrDefault($team->image) }}')"></div>
                               <div class="card-desc">
                                    <h5 class=" credit-title">{{ languageStatus() == 'en' ? ($team->name_en ??null) : ( $team->name_bn ??null) }}</h5>
                                    <p class="card-text credit-position">{{ languageStatus() == 'en' ? ($team->designation_en ??null) : ($team->designation_bn ??null) }}</p>
                                    <span class="line"></span>
                                    <p class="card-text credit-details mt-3">{{ languageStatus() == 'en' ? ($team->details_en ??null) : ( $team->details_bn ??null) }}</p>

                            </div>
                           </div>
                       @endforeach --}}
                    </div>
                </div>


                <div class="trapezoid-3 mx-auto d-block mt-4">
                    <h4 class="text-center pt-2 text-white a2i-header">{{ languageStatus() == 'en' ? 'Business Automation Ltd' : 'বিজনেস অটোমেশন লিমিটেড' }}</h4>
                </div>

                <div class="mt-4">
                    <div class="credit-card d-flex">
                        @foreach($ba_team as $team)
                            <div class="credit-card-item card border-0 py-2">
                                <div class="card-img" style="background-image: url('/{{ \App\Libraries\CommonFunction::setImageOrDefault($team->image) }}')"></div>
                                <div class="card-desc">
                                    <h5 class=" credit-title">{{ languageStatus() == 'en' ? ($team->name_en ??null) : ( $team->name_bn ??null) }}</h5>
                                    <p class="card-text credit-position">{{ languageStatus() == 'en' ? ($team->designation_en ??null) : ($team->designation_bn ??null) }}</p>
                                    <span class="line"></span>
                                    <p class="card-text credit-details mt-3">{{ languageStatus() == 'en' ? ($team->details_en ??null) : ( $team->details_bn ??null) }}</p>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
