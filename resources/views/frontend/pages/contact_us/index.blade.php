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

                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Contact US' : "যোগাযোগ" }}</li>
                </ul>
            </div>
            <div class="nfis-page-heading">
                <h2>
                    {{ languageStatus() == 'en' ? 'Contact US' : "যোগাযোগ" }}
                </h2>
            </div>

            <div class="contact-us pb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="contact-details">
                                <div class="contact-details-data">
                                    <p class="name">
                                        {{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_one_name_en : Session::get('global_setting')->contact_person_one_name_bn }}
                                    </p>
                                    <p class="designation">{{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_one_designation_en : Session::get('global_setting')->contact_person_one_designation_bn }}</p>
                                    @if(!empty(Session::get('global_setting')->contact_person_one_email))
                                        <p class="contact-info"><i class="fas fa-envelope"></i>  {{ Session::get('global_setting')->contact_person_one_email }}</p>
                                    @endif
                                    @if(!empty(Session::get('global_setting')->contact_person_one_phone))
                                        <p class="contact-info">Call us at: {{ Session::get('global_setting')->contact_person_one_phone }}</p>
                                    @endif

                                </div>


                                <div class="contact-details-data">
                                    <p class="name">
                                        {{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_two_name_en : Session::get('global_setting')->contact_person_two_name_bn }}
                                    </p>
                                    <p class="designation">{{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_two_designation_en : Session::get('global_setting')->contact_person_two_designation_bn }}</p>

                                @if(!empty(Session::get('global_setting')->contact_person_two_email))
                                        <p class="contact-info"><i class="fas fa-envelope"></i>  {{ Session::get('global_setting')->contact_person_two_email }}</p>
                                    @endif
                                    @if(!empty(Session::get('global_setting')->contact_person_two_phone))
                                        <p class="contact-info">Call us at: {{ Session::get('global_setting')->contact_person_two_phone }}</p>
                                    @endif                                </div>


                               <div class="contact-details-data">
                                   <p class="name">
                                       {{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_three_name_en : Session::get('global_setting')->contact_person_three_name_bn }}
                                   </p>
                                   <p class="designation">{{ languageStatus() == 'en' ? Session::get('global_setting')->contact_person_three_designation_en : Session::get('global_setting')->contact_person_three_designation_bn }}</p>

                               @if(!empty(Session::get('global_setting')->contact_person_three_email))
                                       <p class="contact-info"><i class="fas fa-envelope"></i>  {{ Session::get('global_setting')->contact_person_three_email }}</p>
                                   @endif
                                   @if(!empty(Session::get('global_setting')->contact_person_three_phone))
                                       <p class="contact-info">Call us at: {{ Session::get('global_setting')->contact_person_three_phone }}</p>
                                   @endif     </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14610.327829151558!2d90.4041669871582!3d23.726618199999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b84f8fbaf56d%3A0x1ef2390cb446587f!2sBangladesh%20Bank%2C%20Head%20Office!5e0!3m2!1sen!2sbd!4v1695550451733!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
