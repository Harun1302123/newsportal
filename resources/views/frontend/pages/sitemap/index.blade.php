@extends('frontend.layouts.master')
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
                <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>

                <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Site map' : "সাইট ম্যাপ" }}</li>
            </ul>
            </div>
            <div class="nfis-page-heading">
                <h2>
                    {{ languageStatus() == 'en' ? 'Site map' : "সাইট ম্যাপ" }}
                </h2>
            </div>

            <div class="site-map pb-4">
                <div class="row">
                    <div class="col-md-10">
                        <ul>
                            <li class="nav-item"><a class="nav-link" href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                            {{-- <li>
                                <a class="nav-link" href="{{ route('frontend.sdgNfis') }}">
                                    {{ languageStatus() == 'en' ? 'SDG & NFIS' : "টেকসই উন্নয়ন অভীষ্ট এবং এনএফআইএস" }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link smoothScroll" href="/#nfisStrategicGoal">
                                    {{ languageStatus() == 'en' ? 'Strategic Goals' : "কৌশলগত লক্ষ্য" }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.stakeholders') }}">
                                    {{ languageStatus() == 'en' ? 'Stakeholder' : "অংশীজন" }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.mAndeFramework') }}">
                                    {{ languageStatus() == 'en' ? 'M & E Framework' : "এম এন্ড ই ফ্রেমওয়ার্ক" }}
                                </a>
                            </li> --}}
                            @foreach($menu_items as $menudata)
                                @if($menudata['status'] == '1')
                                    <li class="nav-item @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) @endif"
                                        href="#">
                                        <a class="nav-link
                            @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0) dd-toggle @endif"
                                           @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                           @else href="/menu/{{ $menudata['slug_name'] }}"
                                            @endif >
                                            {{ languageStatus() == 'en' ? $menudata['menu_name'] : ($menudata['menu_name_bn'] ? $menudata['menu_name_bn'] : $menudata['menu_name'] )  }}
                                        </a>
                                        @if(!empty($menudata['level_one_menus']) && count($menudata['level_one_menus'])>0)
                                            <ul class="pl-4">
                                                @foreach($menudata['level_one_menus'] as $level_one_menu)
                                                    @if($level_one_menu['status'] == '1')
                                                        <li class=" nav-item @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-submenu @endif">
                                                            <a @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) @else href="/menu/{{ $level_one_menu['slug_name'] }}"
                                                               @endif
                                                               class="nav-link @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0) dd-toggle @endif">
                                                                {{ languageStatus() == 'en' ? $level_one_menu['menu_name'] : ($level_one_menu['menu_name_bn'] ? $level_one_menu['menu_name_bn'] : $level_one_menu['menu_name'] )  }}
                                                            </a>
                                                            @if(!empty($level_one_menu['level_two_menus']) && count($level_one_menu['level_two_menus'])>0)
                                                                <ul class="pl-4">
                                                                    @foreach($level_one_menu['level_two_menus'] as $level_two_menu)
                                                                        @if($level_two_menu['status'] == '1')
                                                                            <li class="nav-item">
                                                                                <a href="/menu/{{ $level_two_menu['slug_name'] }}"
                                                                                   class="nav-link">
                                                                                    {{ languageStatus() == 'en' ? $level_two_menu['menu_name'] : ($level_two_menu['menu_name_bn'] ? $level_two_menu['menu_name_bn'] : $level_two_menu['menu_name'] )  }}
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{ languageStatus() == 'en' ? 'Footer Menu' : "ফুটার মেনু" }}
                                </a>
                                <ul class="pl-4">
                                    <li class="nav-item"><a class="nav-link" href="#">{{ languageStatus() == 'en' ? 'Contact US' : "যোগাযোগ" }}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#"> {{ languageStatus() == 'en' ? 'Credit' : "ক্রেডিট" }}</a></li>
                                    <li class="nav-item"><a class="nav-link" target="_blank" href="{{ asset("docs/Citizen's_Charter_of_BB_NFIS_Tracker.pdf") }}">{{ languageStatus() == 'en' ? 'Citizen Charter' : "সিটিজেন চার্টার" }}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">{{ languageStatus() == 'en' ? 'Useful Link' : "দরকারী লিংক" }}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.faq.list') }}">{{ languageStatus() == 'en' ? 'FAQ' : "এফএকিউ" }}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('sitemap') }}">{{ languageStatus() == 'en' ? 'Site map' : "সাইট ম্যাপ" }}</a></li>
                                </ul>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
