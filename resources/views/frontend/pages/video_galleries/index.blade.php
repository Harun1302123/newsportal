@extends('frontend.layouts.master')

@section('content')
    <main class="site-main-content">
        <div class="nfis-breadcrumb">
            <div class="container">
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
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Video Gallery' : "ভিডিও গ্যালারি" }}</li>
                </ul>
            </div>
        </div>

        <section class="gallery-sec">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="page-title">
                        <h2> {{ languageStatus() == 'en' ? 'Video Gallery' : "ভিডিও গ্যালারি" }}</h2>
                    </div>

                    <div class="nfis-filter-sec">
                        <div class="filter-title"><span class="icon-filter"></span> {{ languageStatus() == 'en' ? 'Filter' : "ফিল্টার" }}</div>
                        {!! Form::select('tutorial_category', $tutorial_categories, null, [
                            'class' => 'form-control',
                            'onchange' => 'filterMediaByCategory(this.value)',
                        ]) !!}
                    </div>
                    <div id="ajaxLoader"></div>
                    <div class="gallery-content" id="galleryContent">
                        <div class="row">
                            @foreach ($video_galleries as $single_media)
                                <div class="col-lg-4 col-md-6 gallery-col">
                                    <div class="gallery-video-item">
                                        <div class="gallery-video-img"
                                             style="background-image: url('{{ CommonFunction::setImageOrDefault($single_media->image ?? null) }}')">
                                            <a class="video-paly-btn" data-fancybox href="{{ $single_media->url ?? null }}"><img
                                                    src="{{ asset('images/icon-video-play-btn-green.svg') }}"
                                                    alt="Play"></a>
                                        </div>
                                        <div class="gallery-video-desc">
                                            <span class="post-date">{{ !empty($single_media->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($single_media->updated_at))) : date('d M, Y', strtotime($single_media->updated_at)) : null }}</span>
                                            <p class="post-title">
                                                {{ languageStatus() == 'en' ? $single_media->title_en ?? null : $single_media->title_bn ?? null }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="nfis-pagination">
                            <div class="d-flex justify-content-center my-5">
                                {!! $video_galleries->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        function filterMediaByCategory(categoryId) {
            let csrf_token = $('input[name="_token"]').val();
            if (categoryId != '') {
                $('#ajaxLoader').css('display', 'block');
                $.ajax({
                    url: '{{route('video.by.category')}}',
                    type: 'post',
                    data: {
                        "_token": csrf_token,
                        categoryId: categoryId
                    },
                    success: function(response) {
                        if (response.responseCode == 1) {
                            $('#galleryContent').html(response.html)
                        }
                        $('#ajaxLoader').hide();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // console.log("Something went wrong.");
                    }
                });
            }
        }
    </script>

@endsection