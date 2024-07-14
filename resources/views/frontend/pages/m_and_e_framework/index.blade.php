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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'M & E Framework' : 'এম অ্যান্ড ই ফ্রেমওয়ার্ক' }}</li>
                </ul>
            </div>
        </div>

        <div class="nfis-page-content">
            <div class="container">
                <div class="goal-page-content nfis-content-container">
                    <div class="nfis-goal-sec">
                        <div class="nfis-page-tab-content">
                            <div class="nfis-sec-title text-center mb-4">
                                <h2>
                                    {{ languageStatus() == 'en' ? 'M & E Framework' : 'এম অ্যান্ড ই ফ্রেমওয়ার্ক' }}
                                </h2>

                                <p style="text-align: justify;">
                                    {{ languageStatus() == 'en' ? 'The Monitoring and Evaluation (M&E) framework captures success or level of achievements relative to the set expected outcomes of any action. M & E Framework of NFIS is developed to track the progress of the implementation of NFIS. ' : 'মনিটরিং অ্যান্ড ইভালুয়েশন (M&E) ফ্রেমওয়ার্ক যেকোন কর্মের সেট প্রত্যাশিত ফলাফলের সাথে সাপেক্ষে সাফল্য বা অর্জনের স্তর ক্যাপচার করে। এনএফআইএস-এর এম অ্যান্ড ই ফ্রেমওয়ার্ক এনএফআইএস বাস্তবায়নের অগ্রগতি ট্র্যাক করার জন্য তৈরি করা হয়েছে।' }}
                                </p>

                                <p style="text-align: justify;">
                                    {{ languageStatus() == 'en' ? 'Financial inclusion is commonly measured in three dimensions: access to financial services; usage of financial services; and quality of the products and service delivery mechanism. Access to financial products and services basically indicates the ability to use the services and products offered by formal financial institutions. Eligibility and nearness are two important criteria to evaluate access. Usage of financial products and services reflects the frequency, extent and duration of usage over time. The usage indicators take count of ownership of Account with financial institutions; Account by the vulnerable groups; and digitally accessible Account. The quality of financial products and services reveals how relevant a financial service or product is to customers. Quality issues are associated with costs of the services, barriers, financial literacy, and consumer protections. Both supply-side and demand-side data will be needed to form a comprehensive understanding of access, usage, and quality.' : 'আর্থিক অন্তর্ভুক্তি সাধারণত তিনটি মাত্রায় পরিমাপ করা হয়: আর্থিক পরিষেবাগুলিতে অ্যাক্সেস; আর্থিক পরিষেবার ব্যবহার; এবং পণ্যের গুণমান এবং পরিষেবা সরবরাহের প্রক্রিয়া। আর্থিক পণ্য এবং পরিষেবাগুলিতে অ্যাক্সেস মূলত আনুষ্ঠানিক আর্থিক প্রতিষ্ঠানগুলির দ্বারা প্রদত্ত পরিষেবা এবং পণ্যগুলি ব্যবহার করার ক্ষমতা নির্দেশ করে। অ্যাক্সেস মূল্যায়ন করার জন্য যোগ্যতা এবং নৈকট্য দুটি গুরুত্বপূর্ণ মানদণ্ড। আর্থিক পণ্য এবং পরিষেবার ব্যবহার সময়ের সাথে সাথে ব্যবহারের ফ্রিকোয়েন্সি, ব্যাপ্তি এবং সময়কাল প্রতিফলিত করে। ব্যবহারের সূচকগুলি আর্থিক প্রতিষ্ঠানের সাথে অ্যাকাউন্টের মালিকানা গণনা করে; ঝুঁকিপূর্ণ গোষ্ঠী দ্বারা অ্যাকাউন্ট; এবং ডিজিটালভাবে অ্যাক্সেসযোগ্য অ্যাকাউন্ট। আর্থিক পণ্য এবং পরিষেবাগুলির গুণমান প্রকাশ করে যে কোনও আর্থিক পরিষেবা বা পণ্য গ্রাহকদের কাছে কতটা প্রাসঙ্গিক। গুণমানের সমস্যাগুলি পরিষেবার খরচ, বাধা, আর্থিক সাক্ষরতা এবং ভোক্তা সুরক্ষার সাথে যুক্ত। অ্যাক্সেস, ব্যবহার এবং গুণমানের একটি বিস্তৃত বোঝার জন্য সরবরাহ-পার্শ্ব এবং চাহিদা-সাইড উভয় ডেটারই প্রয়োজন হবে।' }}
                                </p>
                            </div>
                            <div class="nfis-tab-container">
                                <div class="main-tab-menu">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li class="nav-item">
                                            <a onclick="setWiseIndicatorsAction(1)" class="nav-link active" data-toggle="tab" href="#mainTabUsage" role="tab" aria-controls="nfisTabUsages" aria-selected="true"> {{ languageStatus() == 'en' ? 'Usage' : 'ব্যবহার' }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a onclick="setWiseIndicatorsAction(10)" class="nav-link" data-toggle="tab" href="#mainTabAccess" role="tab" aria-controls="nfisTabAccess" aria-selected="false">{{ languageStatus() == 'en' ? 'Access' : 'অ্যাক্সেস' }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a onclick="setWiseIndicatorsAction(11)" class="nav-link" data-toggle="tab" href="#mainTabQuality" role="tab" aria-controls="nfisTabQuality" aria-selected="false">{{ languageStatus() == 'en' ? 'Quality' : 'গুণমান' }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content main-tab-content">
                                    <div class="tab-pane fade show active" id="mainTabUsage" role="tabpanel" aria-labelledby="nfisTabUsages">
                                        <div class="nfis-tab-pane">
                                            <div class="nfis-goal-tab-menu nfis-indicator-tab-menu">
                                                <div class="npi-target-tablists">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item npt-style-01">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(1)" class="nav-link active" href="#nfisGoalTabOne" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set A' : 'সেট A' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-02">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(2)" class="nav-link" href="#nfisGoalTabTwo" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set B' : 'সেট B' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-03">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(3)" class="nav-link" href="#nfisGoalTabThree" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set C' : 'সেট C' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-04">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(4)" class="nav-link" href="#nfisGoalTabFour" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set D' : 'সেট D' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-05">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(5)" class="nav-link" href="#nfisGoalTabFive" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set E' : 'সেট E' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-06">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(6)" class="nav-link" href="#nfisGoalTabSix" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set F' : 'সেট F' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-07">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(7)" class="nav-link" href="#nfisGoalTabSeven" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set G' : 'সেট G' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-08">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(8)" class="nav-link" href="#nfisGoalTabEight" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set H' : 'সেট H' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>

                                                        <li class="nav-item npt-style-09">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(9)" class="nav-link" href="#nfisGoalTabNine" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set I' : 'সেট I' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="nfis-goal-tab-content">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active show" id="nfisGoalTabOne">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabTwo">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabThree">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabFour">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabFive">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabSix">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabSeven">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabEight">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisGoalTabNine">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="mainTabAccess" role="tabpanel" aria-labelledby="nfisTabAccess">
                                        <div class="nfis-tab-pane">
                                            <div class="nfis-goal-tab-menu nfis-indicator-tab-menu">
                                                <div class="npi-target-tablists">
                                                    <ul class="nav-tabs">
                                                        <li class="nav-item npt-style-01">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(10)" class="nav-link active" href="#nfisAccessTabOne" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set J' : 'সেট J' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="nfis-goal-tab-content">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active show" id="nfisAccessTabOne">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="mainTabQuality" role="tabpanel" aria-labelledby="nfisTabQuality">
                                        <div class="nfis-tab-pane">
                                            <div class="nfis-goal-tab-menu nfis-indicator-tab-menu">
                                                <div class="npi-target-tablists">
                                                    <ul class="nav-tabs">
                                                        <li class="nav-item npt-style-01">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(11)" class="nav-link active" href="#nfisQualityTabOne" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set k' : 'সেট k' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item npt-style-02">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(12)" class="nav-link" href="#nfisQualityTabTwo" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set L' : 'সেট L' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item npt-style-03">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(13)" class="nav-link" href="#nfisQualityTabThree" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set M' : 'সেট M' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item npt-style-04">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(14)" class="nav-link" href="#nfisQualityTabFour" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set N' : 'সেট N' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item npt-style-05">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(15)" class="nav-link" href="#nfisQualityTabFive" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set O' : 'সেট O' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item npt-style-06">
                                                            <div class="nfis-tab-menu-item">
                                                                <a onclick="setWiseIndicatorsAction(16)" class="nav-link" href="#nfisQualityTabSix" data-toggle="tab">
                                                                    <div class="tab-menu-title">
                                                                        <span class="tabmenu-num">{{ languageStatus() == 'en' ? 'Set P' : 'সেট P' }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="nfis-goal-tab-content">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active show" id="nfisQualityTabOne">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisQualityTabTwo">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisQualityTabThree">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisQualityTabFour">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisQualityTabFive">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nfisQualityTabSix">
                                                        <div class="tab-sec-title">
                                                            <div class="load_set_title_div"></div>
                                                        </div>
                                                        <div class="nfis-mef-tab-content">
                                                            <div class="nfis-mef-list-content">
                                                                <p>{{ languageStatus() == 'en' ? 'Indicators Name :' : 'সূচকের নাম:' }}</p>
                                                                <ul>
                                                                    <div class="load_data_div"></div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('script')
<script>

    function setWiseIndicatorsAction(set_id) {
        if (!set_id) {
            return;
        }
        let setTitleText = "";
        let indicatorList = "";
        let languageStatus = "{{languageStatus()}}";

        $.ajax({
            url: "{{ route('set_wise_indicators_info') }}",
            type: "get",
            data: {
                set_id: set_id,
            },
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
                if(languageStatus == "en"){
                    setTitleText = "<h3>" + data.setTitle + "</h3>";
                    $(".load_set_title_div").html(setTitleText);

                    data.indicatorInfo.forEach(function (item) {
                        indicatorList += "<li>" + item + "</li>";
                    });
                    $(".load_data_div").html(indicatorList);
                }else{
                    setTitleText = "<h3>" + data.setTitleBn + "</h3>";
                    $(".load_set_title_div").html(setTitleText);

                    data.indicatorInfoBn.forEach(function (item) {
                        indicatorList += "<li>" + item + "</li>";
                    });
                    $(".load_data_div").html(indicatorList);
                }
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    setTimeout(setWiseIndicatorsAction(1), 0);


</script>
@endsection
