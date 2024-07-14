<section class="home-photo-gallery">
    <div class="container">
        <div class="nfis-slider-content">
            <div class="nfis-sec-title">
                <h2>{{ languageStatus() == 'en' ? 'Photo Gallery' : "ফটো গ্যালারি" }}</h2>
            </div>

            <div class="nfisPhotoSlider owl-carousel owl-theme">
                @foreach($photo_galleries as $photo_gallery)
                    <div class="item">
                        <a href="{{ route('frontend.photoGalleries.show', ['id' => Encryption::encodeId($photo_gallery->resource_category)]) }}" class="photo-slide-item">
                            <div class="photo-item-img" style="background-image: url({{ asset($photo_gallery->image??null) }});" onerror="this.src=`{{asset('images/no_image.webp')}}`"></div>
                            <div class="photo-item-desc">
                                <p>{{ languageStatus() == 'en' ? (Str::limit($photo_gallery->title_en, 30)??null) : ($photo_gallery->title_bn??null) }}</p>
                            </div>
                            <span class="photo-item-date">{{CommonFunction::dateTimeInterval( $photo_gallery->updated_at ?? null, $photo_gallery->created_at ?? null)}}</span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="sec-seemore-group">
                <a class="nfis-sec-btn" href="{{ route('frontend.photoGalleries.list') }}">
                    {{ languageStatus() == 'en' ? 'More Photos' : "আরও ছবি" }}
                    <span class="icon-btn-arrow-clr"></span>
                </a>
            </div>
        </div>
    </div>
</section>
