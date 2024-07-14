<section class="e-participation-sec bg-white">
    <div class="container">
        <div class="nfis-sec-title">
            <h2>{{ languageStatus() == 'en' ? 'E-participation' : "ই-পার্টিসিপেশন" }}</h2>
        </div>
        <div class="e-participe-lists">
            <div class="ept-col">
                    <a  class="participe-item bg-style-0" href="{{ route('poll_details') }}">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-01.svg') }}" alt="Polling"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Polling' : "ভোট দিন" }}</span>
                    </a>
            </div>

            <div class="ept-col">
                <a href="{{ route('frontend.comments') }}" class="participe-item bg-style-02">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-02.svg') }}" alt="Comment"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Comment' : "মন্তব্য" }}</span>
                </a>
            </div>

            <div class="ept-col">
                <a href="https://www.youtube.com/" class="participe-item bg-style-03">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-03.svg') }}" alt="Subscribe"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Subscribe' : "সাবস্ক্রাইব" }}</span>
                </a>
            </div>
            <div class="ept-col">
                    <a  class="participe-item bg-style-0" href="{{ route('important_link') }}">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-04.svg') }}" alt="Useful Link"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Useful Link' : "দরকারি লিংক" }}</span>
                    </a>
            </div>

            <div class="ept-col">
                    <a  class="participe-item bg-style-5" href="{{ route('frontend.resource') }}">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-05.svg') }}" alt="NFIS Resource"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'NFIS Resource' : "এনএফআইএস রিসোর্স" }}</span>
                    </a>
            </div>

            <div class="ept-col">
                <a href="https://www.facebook.com/" class="participe-item bg-style-07">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-06.svg') }}" alt="Facebook"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Facebook' : "ফেসবুক" }}</span>
                </a>
            </div>

            <div class="ept-col">
                <a href="https://www.youtube.com/" class="participe-item bg-style-07">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-07.svg') }}" alt="Youtube"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Youtube' : "ইউটিউব" }}</span>
                </a>
            </div>

            <div class="ept-col">
                <a href="tel:123-456-7890" class="participe-item bg-style-07" data-toggle="tooltip" data-placement="top" title="tel:123-456-7890">
                    <span class="ept-icon"><img src="{{ asset('images/e-participation-icon-08.svg') }}" alt="Hotline"></span>
                    <span class="ept-name">{{ languageStatus() == 'en' ? 'Hotline' : "হট লাইন" }}</span>
                </a>
            </div>
        </div>
    </div>
</section>
