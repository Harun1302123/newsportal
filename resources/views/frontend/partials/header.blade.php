<div id="searchOuter" class="">
    <div class="sdg-search">
        <div class="container">
            <div class="sdg-search-wrap">
                <form role="search" action="" method="GET">
                    <input class="sdg-src-input" type="text" name="search" value="" id="searchInput" placeholder="{{ languageStatus() == 'en' ? 'Searching' : "অনুসন্ধান" }}">
                    <span id="search_note">{{ languageStatus() == 'en' ? 'Hit enter to search or ESC to close' : "অনুসন্ধান করতে এন্টার বা বন্ধ করতে ESC টিপুন" }}</span>
                </form>
                <span class="sdgSrcClose" id="closeSearch" ><i class="fas fa-times"></i></span>
            </div>
            <div id="searchResults"></div>
        </div>
    </div>
</div>

<header class="site-header">
    @if(!config('app.is_mobile'))
    <div class="header-top">
        <div class="container">
            <div class="h-topbar">
                @if (Session::has('global_setting'))
                    <a class="top-play-glance" data-fancybox href="{{ Session::get('global_setting')->at_a_glance_link }}">{{ languageStatus() == 'en' ? 'At a glance NFIS' : "এক নজরে এনএফআইএস" }}</a>
                @else
                    <a class="top-play-glance" data-fancybox href="https://youtu.be/O5VOdMbBZlI">{{ languageStatus() == 'en' ? 'At a glance NFIS' : "এক নজরে এনএফআইএস" }}</a>
                @endif
              
                <div class="htop-date ml-auto">
                    <span class="date-eng">
                        {{ languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishTimeToBangla(now()->formatLocalized('%I:%M %p')) : now()->formatLocalized('%I:%M %p') }}
                    </span>
                    <span class="date-eng">
                        {{ languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(now()->formatLocalized('%d %B %Y')) : now()->formatLocalized('%d %B %Y')  }}
                    </span>
                    <span class="date-bn">
                        {{ $bn_date }}
                    </span>
                </div>
                <div class="htop-right d-flex">
                    @if(Auth::user())
                        <a href="{{ route('dashboard') }}" class="nfis-btn dashboard-btn"><i class="far fa-id-card"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="nfis-btn"><span class="icon-btn-arrow-white"></span> {{ languageStatus() == 'en' ? 'Login' : "লগইন" }}</a>
                    @endif
                    <a href="#" class="nfis-lang-btn" data-myvalue="{{ Session::get('locale') ?? 'en' }}">
                        {{ languageStatus() == 'bn' ? 'বাং' : 'EN' }}
                        <span class="icon-lang-toggler"></span></a>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.partials.nav')

    @else

    @include('frontend.partials.nav')
    
    @endif
</header>
