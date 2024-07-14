<section class="home-banner-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="home-banner-slider">
                    @if ($banners->toArray())
                        <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="7000">
                            <div class="carousel-inner">
                                @foreach ($banners as $index => $banner)

                                    @if(!empty($banner->title_en))
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="nfis-hbs-item photo-right" style="background-color: #f2f2f4;">
                                                <div class="slider-single-photo">
                                                    <img src="{{ asset($banner->image??null)}}" alt="{{ $banner->title_en }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                                                </div>
                                                <div class="hbs-slide-caption">
                                                    <p class="hbs-msg-text">{{ languageStatus() == 'en' ? ($banner->description_en??null) : ($banner->description_bn??null ) }}</p>
                                                    <p class="hbs-msg-name"><strong>{{ languageStatus() == 'en' ? ($banner->title_en??null) : ($banner->title_bn??null ) }}</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="nfis-hbs-item photo-left" style="background-image: url({{ asset($banner->image) }})"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="slider-nav">
                                <a class="slide-nav-prev" href="#carousel" role="button" data-slide="prev">
                                    <span class="slider-arrow"></span>
                                </a>
                                <a class="slide-nav-next" href="#carousel" role="button" data-slide="next">
                                    <span class="slider-arrow"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="nfis-msg-lists">
                    <div class="msg-title">
                        <h4>{{ languageStatus() == 'en' ? 'Messages' : "বার্তা" }}</h4>
                    </div>
                    @if ($biographies->toArray())
                        <div class="nfis-msg-block">
                            @foreach ($biographies as $biography)
                                <div class="nfis-msg-item">
                                    <div class="msg-item-photo" style="background-image: url('{{ CommonFunction::setImageOrDefault($biography->image??null) }}')"></div>
                                    <div class="msg-item-desc">
                                        <h5>{{ languageStatus() == 'en' ? ($biography->name_en??null) : ($biography->name_bn??null ) }}</h5>
                                        <p>
                                            <span class="msg-designation">{{ languageStatus() == 'en' ? ($biography->designation_en??null) : ($biography->designation_bn??null) }} </span>
                                            <span class="msg-depertment">{{ languageStatus() == 'en' ? ( $biography->organization_en??null) : ( $biography->organization_bn??null) }}</span>
                                            <a href="{{ route('frontend.biography.detail',['id' => Encryption::encodeId($biography->id)]) }}" class="msg-details-btn">@lang("messages.details")</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
