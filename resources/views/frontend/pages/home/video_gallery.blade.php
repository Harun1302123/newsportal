<section class="home-video-gallery">
    <div class="container">
        <div class="nfis-slider-content">
            <div class="nfis-sec-title">
                <h2>{{ languageStatus() == 'en' ? 'Watch Video' : "ভিডিও দেখুন" }}</h2>
            </div>
            @if ($video_galleries->toArray())
                <div class="nfisVideoSlider owl-carousel owl-theme">
                    @foreach ($video_galleries as $single_media)
                        <div class="item">
                            <div class="video-slide-item">
                                <div class="video-item-img" style="background-image: url('{{ CommonFunction::setImageOrDefault($single_media->image??null) }}')">
                                    <a class="video-paly-btn" data-fancybox href="{{$single_media->url??null}}"><img src="{{ asset('images/icon-video-play-btn-green.svg') }}" alt="{{ $single_media->title_en }}"></a>
                                </div>
                                <div class="video-item-desc">
                                    <p>{{ languageStatus() == 'en' ? $single_media->title_en??null : $single_media->title_bn??null }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="sec-seemore-group">
                <a class="nfis-sec-btn" href="{{ route('frontend.videoGalleries.list') }}">
                    {{ languageStatus() == 'en' ? 'More Videos' : "আরও ভিডিও" }}
                    <span class="icon-btn-arrow-clr"></span></a>
            </div>
        </div>
    </div>
</section>
