@extends('frontend.layouts.master')

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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'SDGs and NFIS' : "টেকসই উন্নয়ন অভীষ্ট এবং এনএফআইএস" }}</li>
                </ul>
            </div>

            <div class="nfis-page-heading">
                <h2>{{ languageStatus() == 'en' ? 'SDGs and NFIS' : "টেকসই উন্নয়ন অভীষ্ট এবং এনএফআইএস" }}</h2>
            </div>
        </div>


        <div class="nfis-page-content">
            <div class="container">
                <div class="goal-target-content nfis-content-container">
                    <h4>{{ languageStatus() == 'en' ? 'Impact of Financial Inclusion on SDGs Goals and Targets:' : 'টেকসই উন্নয়ন অভীষ্ট (এসডিজি) অর্জনে এনএফআইএস এর প্রভাব' }}</h4>

                    <div class="goal-target-lists">
                        <div class="gtarget-head gt-list-block">
                            <div class="list-goal"><h5>{{ languageStatus() == 'en' ? 'Goal' : 'অভীষ্ট' }}</h5></div>
                            <div class="list-target"><h5>{{ languageStatus() == 'en' ? 'Targets' : 'লক্ষ্যমাত্রা' }}</h5></div>
                            <div class="list-impact"><h5>{{ languageStatus() == 'en' ? 'Impact' : 'প্রভাব' }}</h5></div>
                        </div>
                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-01.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '1.1, 1.3, 1.4, 1.5, 1.b' : '১.১, ১.৩,  ১.৪, ১.৫, ১খ' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Create jobs and support the Government’s plan to reduce extreme poverty' : 'দারিদ্র্য দূরীকরণের লক্ষ্যে কর্মসংস্থান সৃষ্টি এবং সরকারের পরিকল্পনাকে সহায়তাকরণ' }}.</li>
                                    <li>{{ languageStatus() == 'en' ? 'Improve reliability and speed of income receipts' : 'আয়ের উৎসমূহের নির্ভরযোগ্য উন্নয়ন ও তরান্বিতকরণ' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-02.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '2.3, 2.4, 2.b, 2.c' : '২.৩, ২.৪, ২খ, ২গ' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Improve productivity of agriculture and increasing food and nutritional security through appropriate financing.' : 'সঠিক অর্থায়নের মাধ্যমে কৃষি উৎপাদনশীলতার উন্নয়ন এবং খাদ্য ও পুষ্টি নিরাপত্তা সমৃদ্ধকরণ' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-03.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '3.c' : '৩গ' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Improve ability to maintain payments for education, health and utility services.' : 'শিক্ষা, স্বাস্থ্য এবং ইউটিলিটি সেবাসমূহের পরিশোধ সক্ষমতার বৃদ্ধিকরণ' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-04.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '4.1, 4.4, 4.6' : '৪.১, ৪.৪, ৪.' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Ensure financial literacy for all and skill development of women and youth' : 'সবার জন্য আর্থিক স্বাক্ষরতা এবং নারী ও যুবাদের দক্ষতার উন্নয়ন নিশ্চিতকরণ' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-05.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '5.1, 5.a' : '৫.১, ৫ক' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Empower women with greater control over personal and commercial finances.' : 'ব্যক্তিগত ও বাণিজ্যিক অর্থায়নে অধিকতর নিয়ন্ত্রণের ক্ষেত্রে নারীর ক্ষমতায়ন' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-06.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '6.3, 6.4' : '৬.৩, ৬.৪' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Catalyzing finance for clean water, sanitation and water efficiency' : 'নিরাপদ পানি, স্যানিটেশন এবং পানি-ব্যবহার দক্ষতা বৃদ্ধিতে সহায়ক অর্থায়ন' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-07.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '7.2, 7.3, 7.a' : '৭.২, ৭.৩, ৭ক' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Catalyzing appropriate financing for renewable energy and energy efficiency.' : 'নবায়নযোগ্য জ্বালানি ও জ্বালানি দক্ষতা বৃদ্ধিতে সহায়ক অর্থায়ন' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-08.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '8.1, 8.2, 8.3, 8.4, 8.5, 8.9, 8.10' : '৮.১, ৮.২, ৮.৩, ৮.৪, ৮.৫, ৮.৯, ৮.১০' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Strengthen financial sector and institutions as well as Improve efficiency transactions.' : 'আর্থিক খাত এবং প্রতিষ্ঠানসমূহের শক্তিশালীকরণ এবং লেনদেনের দক্ষতার উন্নয়ন' }}</li>
                                    <li>{{ languageStatus() == 'en' ? 'Support businesses to manage liquidity, access credit, mobilize savings for investment and mitigate economic shocks.' : 'তারল্য ব্যবস্থাপনা, ঋণ প্রাপ্তি ও বিনিয়োগের লক্ষ্যে প্রয়োজনীয় আমানত জোগান ও অর্থনৈতিক অভিঘাত হ্রাসে ব্যবসা প্রতিষ্ঠানসমূহকে সহায়তাকরণ' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-09.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '9.2, 9.3, 9.4' : '৯.২, ৯.৩, ৯.৪' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Modernize the financial system and channel banking sector funds to underserved.' : 'আর্থিক ব্যবস্থার আধুনিকায়ন ও বঞ্চিত জনগোষ্ঠীর জন্য ব্যাংক খাতের অর্থায়ন প্রাপ্তির সুযোগ নিশ্চিতকরণ' }}</li>
                                    <li>{{ languageStatus() == 'en' ? 'Dress market failures across credit and insurance markets' : 'ঋণ এবং বীমা বাজারের ত্রুটিসমূহ চিহ্নিতকরণ' }}</li>
                                    <li>{{ languageStatus() == 'en' ? 'Facilitate access to capital for startups' : 'নতুন উদ্যোক্তাদের জন্য মূলধন জোগান' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-10.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '10.1, 10.2, 10.5, 10.c' : '১০.১, ১০.২, ১০.৫, ১০গ' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Promoting inclusive finance' : 'অন্তর্ভুক্তিমূলক অর্থায়নের প্রসার' }} </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-11.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '11.1, 11.2, 11.3' : '১১.১, ১১.২, ১১.৩' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Catalyzing finance for affordable housing, safe transportation and resilient cities.' : 'সাশ্রয়ী বাসস্থান, নিরাপদ পরিবহন এবং অভিঘাতসহনশীল নগর প্রতিষ্ঠায় অর্থায়ন' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-13.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '13.1, 13.2, 13.a' : '১৩.১, ১৩.২, ১৩ক' }}</p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Improve resilience against environmental vulnerability.' : 'পরিবেশগত ঝুঁকি মোকাবেলায় অভিঘাতসহনশীলতা বৃদ্ধি' }}</li>
                                    <li>{{ languageStatus() == 'en' ? 'Support green financing to improve environmental sustainability' : 'টেকসই পরিবেশ উন্নয়নে পরিবেশবান্ধ অর্থায়নের প্রসার' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-16.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '16.4, 16.5' : '১৬.৪, ১৬.৫' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Combating illicit financing and preventing fund flow for terrorist activities through anti-money laundering' : 'অবৈধ অর্থায়ন রোধ এবং অ্যান্টি-মানি লন্ডারিংয়ের মাধ্যমে সন্ত্রাসবাদী কার্যক্রমে অর্থ প্রবাহের প্রতিরোধকরণ' }}. </li>
                                </ul>
                            </div>
                        </div>

                        <div class="gtarget-item gt-list-block">
                            <div class="list-goal">
                                <div class="gt-icon">
                                    <img src="{{ asset('images/goal-target-img-17.svg') }}" alt="Icon">
                                </div>
                            </div>
                            <div class="list-target">
                                <p>{{ languageStatus() == 'en' ? '17.14, 17.17, 17.18, 17.19' : '১৭.১৪, ১৭,১৭, ১৭.১৮, ১৭.১৯' }} </p>
                            </div>
                            <div class="list-impact">
                                <ul class="gt-lists">
                                    <li>{{ languageStatus() == 'en' ? 'Coordinate, coherent policy through effective partnership for sustainable development' : 'কার্যকর অংশীদারিত্বের মাধ্যমে টেকসই উন্নয়নের জন্য নীতিমালাসমূহের মধ্যে সমন্বয় সাধন' }}</li>
                                    <li>{{ languageStatus() == 'en' ? 'Development of high-quality, timely and reliable data disaggregated by income, gender, age, geographic location and other characteristics' : 'আয়, লিঙ্গ, বয়স, ভৌগোলিক অবস্থান এবং অন্যান্য বৈশিষ্ট্যের ভিত্তিতে সম্বলিত মানসম্পন্ন, সময়োপযোগী এবং নির্ভরযোগ্য তথ্য সংগ্রহকরণ' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
