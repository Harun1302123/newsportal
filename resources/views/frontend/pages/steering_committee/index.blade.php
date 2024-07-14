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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Details' : "বিস্তারিত" }}</li>
                </ul>
            </div>

            <div class="nfis-page-heading">
                <h2>NFIS Steering Committee (NSC)</h2>
            </div>

            <div class="sec-intor-text">
                <p>This committee will have the overall responsibility of implementing the NFIS- B following the guidance of the NNC. The NSC will be responsible for ensuring coordination, effectiveness and quality control in all activities under the financial inclusion agenda. The NSC will be chaired by the Governor, Bangladesh Bank. Any change(s) in the ToR or structure of NSC has to be approved by NNC. </p>
            </div>
        </div>


        <div class="nfis-page-content">
            <div class="container">
                <div class="nsc-page-content nfis-content-container">
                    <h4>The structure of the NSC will be as follows:</h4>

                    <div class="nsc-sec-content">
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">1.</span> Governor, Bangladesh Bank</p>
                            <span class="nsc-list-position">-Chair</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">2.</span> Secretary, Financial Institutions Division, Ministry of Finance </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">3.</span> Secretary, Finance Division, Ministry of Finance</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">4.</span> Secretary, Economic Relations Division, Ministry of Finance</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">5.</span> Secretary, Internal Resources Division, Ministry of Finance</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">6.</span> Member, General Economic Division, Ministry of Planning</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">7.</span> Secretary, Ministry of Agriculture</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">8.</span> Secretary, Ministry of Women & Children Affairs</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">9.</span> Secretary, Ministry of Commerce</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">10.</span> Secretary, Ministry of Industry </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">11.</span> Secretary, Ministry of Social Welfare</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">12.</span> Secretary, Local Government Division, Ministry of LGRD and Co-operatives</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">13.</span> Secretary, Rural Development and Co-operatives Division, Ministry of LGRD and Co-operatives</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">14.</span> Secretary, Ministry of Expatriates’ Welfare & Overseas Employment</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">15.</span> Secretary, Ministry of Labor and Employment</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">16.</span> Secretary, ICT Division, Ministry of Posts, Telecommunications and Information Technology</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">17.</span> Secretary, PTD, Ministry of Posts, Telecommunications and Information Technology</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">18.</span> Secretary, Ministry of Primary & Mass Education</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">19.</span> Secretary, Secondary and Higher Education Division, Ministry of Education</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">20.</span> Secretary, Health Services Division, Ministry of Health and Family Planning</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">21.</span> Secretary, Medical Education & Family Welfare Division, Ministry of Health and Family Planning </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">22.</span> Secretary, Ministry of Youth and Sports</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">23.</span> Secretary, Bangladesh Election Commission</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">24.</span> Chairman, Insurance Development and Regulatory Authority</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">25.</span> Chairman, Bangladesh Securities and Exchange Commission</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">26.</span> Executive Vice Chairman, Microcredit Regulatory Authority</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">27.</span> Chairman, Bangladesh Telecommunication Regulatory Commission</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">28.</span> Chairman, Bangladesh Investment Development Authority  </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">29.</span> Controller General of Accounts, Office of the Comptroller and Auditor General of Bangladesh</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">30.</span> Director General, NIDW, Bangladesh Election Commission</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">31.</span> Director General, Department of Cooperatives</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">32.</span> Director General, Bangladesh Post Office</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">33.</span> Chairman, Association of Bankers Bangladesh</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">34.</span> Chairman, Bangladesh Leasing and Finance Companies Association</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">35.</span> President, Association of Mobile Telecom Operators of Bangladesh </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">36.</span> President, Bangladesh Employers’ Federation</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">37.</span> Director General, Bangladesh Institute of Development Studies</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">38.</span> Director General, Bangladesh Institute of Bank Management</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">39.</span> Executive President, Bangladesh Institution of Capital Market</p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">40.</span> Director, Bangladesh Insurance Academy </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">41.</span> Executive Director, Institute for Inclusive Finance and Development </p>
                            <span class="nsc-list-position">-Member</span>
                        </div>
                        <div class="nsc-list-item">
                            <p><span class="nsc-list-num">42.</span> Executive Director, NFIS Administrative Unit, Bangladesh Bank</p>
                            <span class="nsc-list-position">-Member Secretary</span>
                        </div>
                    </div>
                </div>

                <div class="nfis-page-heading mt-5">
                    <h2>The ToR of the NSC will be as follows:</h2>
                </div>
                <div class="nsc-follow-text">
                    <p>1. Ensure coordination and timely undertaking of the activities of NFIS National Secretariat (discussed below), review progress of implementation, and suggest ways to overcome critical obstacles and exploit opportunities; </p>
                    <p>2. Provide guidance to the National Secretariat on issues related to financial inclusion related activities; </p>
                    <p>3.Suggest modalities for inter- and intra-institutional collaboration and cooperation in both public and private sectors; </p>
                    <p>4.Indicate priorities and guidelines for preparing detailed action plan and required resources for implementing the financial inclusion agenda; </p>
                    <p>5.Ensure that a properly functional NFIS Administrative Unit is in place with capacity to efficiently perform its roles and responsibilities;</p>
                    <p>6.Review progress of implementation and finalize recommendations for consideration of the NNC at least three times a year.</p>
                    <p>7.The committee can co-opt member anytime deem necessary.</p>
                    <p>8.Perform any other function as guided by the NNC.</p>
                </div>
            </div>
        </div>

    </main>
@endsection
