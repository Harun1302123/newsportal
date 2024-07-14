@extends('frontend.layouts.master')

@section('content')
    <main class="site-main-content">
        <div class="nfis-breadcrumb">
            <div class="container">
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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Goal View' : "লক্ষ্য ভিউ" }}</li>

                </ul>
            </div>
        </div>

        <section class="goal-view-sec">
            <div class="container">
                <div class="page-title">
                    <h2>
                        {{ languageStatus() == 'en' ? 'Goal View' : "লক্ষ্য ভিউ" }}
                    </h2>
                </div>
                <div class="goal-view-content">
                    <div class="glv-tab-lists">
                        <ul class="nav-tabs">
                            @foreach($goals as $index=> $data)
                            <li class="nav-item glv-tab-menu-item glv-style-0{{ !empty($data->order) ? $data->order : '1' }}">
                                <a class="nav-link {{ $index==0 ? 'active' : '' }}" href="#nfisGoalViewTab{{ !empty($data->order) ? $data->order : '1' }}" data-toggle="tab">
                                    <span class="tabmenu-num">
                                        {{  languageStatus() == 'bn' ? \App\Libraries\CommonFunction::convertToBanglaNumber($data->order) : $data->order  }}
                                    </span>
                                    <span class="tabmenu-text">
                                        {{ languageStatus() == 'en' ? ($data->title_en??null) : ($data->title_bn??null) }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="glv-tab-content">
                        <div class="tab-content">
                            @foreach($goals as $data)
                                <div class="tab-pane fade @if($loop->first) active show @endif" id="nfisGoalViewTab{{ !empty($data->order) ? $data->order : '1' }}">
                                    <div class="tab-sec-title">
                                        <h3>
                                            {{  languageStatus() == 'bn' ? \App\Libraries\CommonFunction::convertToBanglaNumber($data->order) : $data->order  }} . {{ languageStatus() == 'en' ? ($data->title_en??null) : ($data->title_bn??null) }}
                                        </h3>
                                    </div>
                                    <div class="glv-tab-sec-content">
                                        <div class="nfis-accordian">

                                            @foreach($data->targets as $item)
                                                <div class="nfis-acd-item">
                                                    <div class="accordian-head @if(!$loop->first)  collapsed @endif " data-toggle="collapse" data-target="#nfisGoalViewTab-{{ $data->id }}{{ $item->id }}" aria-expanded="true" aria-controls="">
                                                        <span class="accordian-indicator "><span class="icon-plus"></span></span>
                                                        <div class="nfis-acd-title">
                                                            <a href="#"><strong>{{ languageStatus() == 'en' ? 'Target' : "টার্গেট " }}  {{ languageStatus() == 'en' ? ($item->target_number_en??null) : ($item->target_number_bn??null) }} :</strong>
                                                                {{ languageStatus() == 'en' ? ($item->title_en??null) : ($item->title_bn??null) }}
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div id="nfisGoalViewTab-{{ $data->id }}{{ $item->id }}" class="collapse @if($loop->first)  show @endif" data-parent="#nfisGoalViewTab-{{ $data->id }}{{ $item->id }}">
                                                        <div class="nfis-acd-content">
                                                            <div class="status-block mb-5">
{{--                                                                <div class="glv-status-item">--}}
{{--                                                                    <p>Status : New Policy/Guidelines Issued or Action Taken </p>--}}
{{--                                                                    <div class="glv-status-action">--}}
{{--                                                                        <span class="status-action-item active"><i class="action-icon icon-circle-tick"></i> Yes</span>--}}
{{--                                                                        <span class="status-action-item"><i class="action-icon icon-circle-close"></i> No</span>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="glv-status-item">--}}
{{--                                                                    <p>Status : Visible Operational Automation Took Place </p>--}}
{{--                                                                    <div class="glv-status-action">--}}
{{--                                                                        <span class="status-action-item"><i class="action-icon icon-circle-close"></i> No</span>--}}
{{--                                                                        <span class="status-action-item active"><i class="action-icon icon-circle-tick"></i> Yes</span>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="glv-status-item">--}}
{{--                                                                    <p>Status : New Inclusive Financial Product Introduced</p>--}}
{{--                                                                    <div class="glv-status-action">--}}
{{--                                                                        <span class="status-action-item"><i class="action-icon icon-circle-tick"></i> Yes</span>--}}
{{--                                                                        <span class="status-action-item active"><i class="action-icon icon-circle-close"></i> No</span>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="glv-status-item item-total">--}}
{{--                                                                    <div class="glv-status-action">--}}
{{--                                                                        <span class="status-action-item active"><strong>Score</strong></span>--}}
{{--                                                                        <span class="status-action-item active"><strong>30%</strong></span>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
                                                            </div>

                                                            <div class="status-block">
                                                                <h5 class="text-center">{{ languageStatus() == 'en' ? 'Implementation Status/ Policy or Guidelines issued/ Changes Taken Place' : 'বাস্তবায়নের স্থিতি/ নীতি বা নির্দেশিকা জারি করা/ পরিবর্তন করা হয়েছে' }} </h5>

                                                                <div class="glv-status-item flex-space-around">
                                                                    <div class="glv-status-action">
                                                                        <span class="status-action-item">{{ languageStatus() == 'en' ? 'Not Implemented' : 'বাস্তবায়িত হয়নি' }}</span>
                                                                    </div>
                                                                    <div class="glv-status-action">
                                                                        <span class="status-action-item active"><i class="action-icon icon-circle-tick"></i>{{ languageStatus() == 'en' ? 'Partly Implemented' : 'আংশিকভাবে বাস্তবায়িত' }}</span>
                                                                    </div>
                                                                    <div class="glv-status-action">
                                                                        <span class="status-action-item">{{ languageStatus() == 'en' ? 'Fully Implemented ' : 'সম্পূর্ণরূপে বাস্তবায়িত' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
