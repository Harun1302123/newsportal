@if(!config('app.is_mobile'))
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-menu">
                <ul>
                    <li><a href="{{ route('frontend.contact.us') }}">{{ languageStatus() == 'en' ? 'Contact US' : "যোগাযোগ" }}</a></li>
                    <li><a href="{{ route('frontend.credit') }}"> {{ languageStatus() == 'en' ? 'Credit' : "ক্রেডিট" }}</a></li>
{{--                    <li><a target="_blank" href="{{ route('citizen.charter') }}" >{{ languageStatus() == 'en' ? 'Citizen Charter' : "সিটিজেন চার্টার" }}</a></li>--}}
{{--                    <li><a href="{{ route('important_link') }}">{{ languageStatus() == 'en' ? 'Useful Link' : "দরকারি লিংক" }}</a></li>--}}
                    <li><a href="{{ route('frontend.faq.list') }}">{{ languageStatus() == 'en' ? 'FAQ' : "এফএকিউ" }}</a></li>
                    <li><a href="{{ route('sitemap') }}">{{ languageStatus() == 'en' ? 'Site map' : "সাইট ম্যাপ" }}</a></li>
                </ul>
            </div>
            <div class="footer-right">
                <div class="nfis-tec-support">
                    <span class="tec-text">{{ languageStatus() == 'en' ? 'Technical Support' : "কারিগরি সহযোগিতায়" }}:</span>
                    <div class="tec-logo">
                        <ul>
                            <li><a href="https://a2i.gov.bd" target="_blank">
                                <picture>
                                    <source srcset="{{ asset('images/technical-support-logo-01.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('images/technical-support-logo-01.png') }}" type="image/jpeg">
                                    <img src="{{ asset('images/technical-support-logo-01.webp') }}" alt="a2i – Aspire to Innovate"></a>
                                </picture>
                            </li>
                            <li>
                                <picture>
                                    <source srcset="{{ asset('images/technical-support-logo-02.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('images/technical-support-logo-02.png') }}" type="image/jpeg">
                                    <a href="https://www.bb.org.bd" target="_blank"><img src="{{ asset('images/technical-support-logo-02.webp') }}" alt="Bangladesh Bank"></a>
                                </picture>
                            </li>
                            <li>
                                <picture>
                                    <source srcset="{{ asset('images/technical-support-logo-03.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('images/technical-support-logo-03.png') }}" type="image/jpeg">
                                    <a href="https://ictd.gov.bd" target="_blank"><img src="{{ asset('images/technical-support-logo-03.webp') }}" alt="ICT Division"></a>
                                </picture>
                            </li>
                            <li>
                                <picture>
                                    <source srcset="{{ asset('images/technical-support-logo-04.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('images/technical-support-logo-04.png') }}" type="image/jpeg">
                                    <a href="https://www.undp.org/bangladesh" target="_blank"><img src="{{ asset('images/technical-support-logo-04.webp') }}" alt="United Nations Development Programme (UNDP), Bangladesh"></a>
                                </picture>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endif
