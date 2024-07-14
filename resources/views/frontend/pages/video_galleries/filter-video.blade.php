@if ($video_galleries->toArray())
    <div class="row">
        @foreach ($video_galleries as $single_media)
            <div class="col-lg-4 col-md-6 gallery-col">
                <div class="gallery-video-item">
                    <div class="gallery-video-img"
                         style="background-image: url('{{ CommonFunction::setImageOrDefault($single_media->image ?? null) }}')">
                        <a class="video-paly-btn" data-fancybox href="{{ $single_media->url ?? null }}"><img
                                src="{{ asset('images/icon-video-play-btn-green.svg') }}" alt="Play"></a>
                    </div>
                    <div class="gallery-video-desc">
                        <span
                            class="post-date">{{ !empty($single_media->updated_at) ? date('d M Y', strtotime($single_media->updated_at)) : null }}</span>
                        <p class="post-title">
                            {{ languageStatus() == 'en' ? $single_media->title_en ?? null : $single_media->title_bn ?? null }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center">
        <h3 class="text-danger">No data found</h3>
    </div>
@endif
