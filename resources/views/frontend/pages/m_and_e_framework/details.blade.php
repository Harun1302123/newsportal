@extends('frontend.layouts.master')
<style>
    .nav-tabs {
        border-bottom: 0 !important;
    }

    .nfis-tab-link {
        border: 1px solid rgb(215, 207, 207) !important;
        padding: 0 !important;
        width: 170px;
        text-align: center;
        height: 53px;
        color: rgb(136, 127, 127);
    }

    .nav-tabs .nav-link.active {
        color: #13AFD9 !important;
    }

    .nav-tabs .nav-link.active::after {
        border-bottom: 6px solid #13AFD9 !important;
    }

    .nav-tabs .nfis-tab-link::before {
        content: "";
        border-bottom: 6px solid #fff !important;
        position: relative;
        bottom: -52px;
        display: block;
        width: 100%;
    }

    .nav-tab-items .active::before {
        content: "";
        border-bottom: 6px solid #13AFD9 !important;
        position: relative;
        bottom: -52px;
        display: block;
        width: 100%;
    }
</style>
@section('content')
    <main class="site-main-content page-height">
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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Details' : "হোম" }}</li>
                </ul>
            </div>
        </div>

        <div class="nfis-page-content">
            <div class="container">
                <div class="goal-page-content nfis-content-container">
                    <div class="nfis-goal-sec">
                        <div class="nfis-page-tab-content">
                            <div class="nfis-sec-title text-center mb-4">
                                <h2>M & E Framework</h2>
                            </div>
                            <div class="card-headerd ">
                                <ul class="nav nav-tabs d-flex justify-content-center py-4" id="myTab" role="tablist">
                                    <li class="nav-item nav-tab-items ">
                                        <a class="nav-link nfis-tab-link mr-4 active" href="#tab_1" data-toggle="tab"
                                            aria-expanded="false">
                                            <h4>Usages</h4>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-tab-items">
                                        <a class="nav-link nfis-tab-link mr-4" href="#tab_2" data-toggle="tab"
                                            aria-expanded="false">
                                            <h4>Access</h4>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-tab-items">
                                        <a class="nav-link nfis-tab-link" href="#tab_3" data-toggle="tab"
                                            aria-expanded="false">
                                            <h4>Quality</h4>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nfis-tab-container tab-content">
                                <div class="nfis-tab-pane tab-pane active" id="tab_1">
                                    <div class="nfis-goal-tab-menu nfis-indicator-tab-menu">
                                        <div class="npi-target-tablists">
                                            <ul class="nav-tabs">
                                                <li class="nav-item npt-style-01">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link active" href="#nfisGoalTabOne" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set A</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-02">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabTwo" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set B</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-03">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabThree" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set C</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-04">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabFour" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set D</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-05">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabFive" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set E</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-06">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabSix" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set F</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item npt-style-07">
                                                    <div class="nfis-tab-menu-item">
                                                        <a class="nav-link" href="#nfisGoalTabSeven" data-toggle="tab">
                                                            <div class="tab-menu-title">
                                                                <span class="tabmenu-num">Set G</span>
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
                                                    <h3>Adults Accounts in Financial Insitutions (FIs)</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabTwo">
                                                <div class="tab-sec-title">
                                                    <h3>Women/Rural Adult Accounts in Fis</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabThree">
                                                <div class="tab-sec-title">
                                                    <h3>Savings/Loan/Insurance Policy/No-Frills/Agent Banking Accounts in
                                                        Fis</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabFour">
                                                <div class="tab-sec-title">
                                                    <h3>Transactions/Financing/Remittance Collection/Loan disbursement by
                                                        FSPs</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabFive">
                                                <div class="tab-sec-title">
                                                    <h3>Financial Access Point & Cost Analysis of FSPs</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabSix">
                                                <div class="tab-sec-title">
                                                    <h3>Beneficiaries of Quasi Financial Regulators</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nfisGoalTabSeven">
                                                <div class="tab-sec-title">
                                                    <h3>Target Tracking</h3>
                                                </div>
                                                <div class="nfis-mef-tab-content">
                                                    <div class="nfis-mef-list-content">
                                                        <p>Indicators Name :</p>
                                                        <ul>
                                                            <li>Banks</li>
                                                            <li>NBFIs</li>
                                                            <li>MFIs</li>
                                                            <li>Insurance Companies</li>
                                                            <li>Capital Intermediaries</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_2" class="tab-pane">
                                    <h2>hi</h2>
                                </div>
                                <div id="tab_3" class="tab-pane">
                                    <h2>hlw</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
