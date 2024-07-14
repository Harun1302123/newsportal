@if ($photo_galleries->toArray())
    <div class="row">
        @foreach ($photo_galleries as $photo_gallery)
            <div class="col-xl-3 col-lg-4 col-md-6 gallery-col">
                <a href="{{ route('frontend.photoGalleries.show', ['id' => Encryption::encodeId($photo_gallery->resource_category)]) }}"
                    class="photo-slide-item">
                    <div class="photo-item-img" style="background-image: url({{ asset($photo_gallery->image ?? null) }});"
                        onerror="this.src=`{{ asset('images/no_image.png') }}`"></div>
                    <div class="photo-item-desc">
                        <p>{{ languageStatus() == 'en' ? Str::limit($photo_gallery->title_en, 30) ?? null : $photo_gallery->title_bn ?? null }}
                        </p>
                    </div>
                    <span
                        class="photo-item-date">{{ CommonFunction::dateTimeInterval($photo_gallery->updated_at ?? null, $photo_gallery->created_at ?? null) }}</span>
                </a>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center">
        <h3 class="text-danger">No data found</h3>
    </div>
@endif
