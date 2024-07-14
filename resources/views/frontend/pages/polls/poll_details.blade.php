@extends('frontend.layouts.master')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<style>
    .vote {
        cursor: pointer;
        font-size: 14px;
    }

    .nfis-news-item .news-item-desc h5 {
        border-bottom: 0 !important;
    }

    .top-boader{
        border-top: 1px solid rgba(112, 112, 112, 0.42);
        padding-top: 10px;
        margin-top: 10px;
        font-size: 16px;
        font-weight: 500;
    }
    
</style>
@endsection
@section('content')
    <main class="site-main-content">
        <div class="nfis-breadcrumb">
            <div class="container">
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
                    <li class="nfis-bc-item"><a
                            href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : 'হোম' }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Polling' : 'ভোটগ্রহণ' }}</li>

                </ul>
            </div>
        </div>
        <section class="gallery-sec">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="page-title">
                        <h2>{{ languageStatus() == 'en' ? 'Polling' : 'ভোটগ্রহণ' }}</h2>
                    </div>

                    <div class="gallery-content" id="galleryContent">
                        <div class="row">
                            @if ($polls->toArray())
                                @foreach ($polls as $item)
                                    <div class="col-xl-3 col-lg-4 col-md-6 gallery-col">
                                        <div class="nfis-news-item">
                                            <div class="news-item-img"
                                                style="background-image: url({{ asset(CommonFunction::setImageOrDefault($item->image ?? null)) }});">
                                            </div>
                                            <div class="news-item-desc">
                                                <h5>
                                                    {{ languageStatus() == 'en' ? $item->title_en ?? null : $item->title_bn ?? null }}
                                                </h5>
                                                @if ($item->description_en || $item->description_bn)
                                                <p class="top-boader">
                                                    {{ languageStatus() == 'en' ? Str::limit(strip_tags($item->description_en), 200) ?? null : Str::limit(strip_tags($item->description_bn), 200) ?? null }}
                                                </p>
                                                @endif
                                            </div>
                                            <div class="sec-seemore-group">
                                                <div class="panel-body">
                                                    <ul class="list-group">
                                                        <li>
                                                            <div class="radio">
                                                                <label class="vote">
                                                                    <input type="radio" name="poll_opinion"
                                                                        id="poll_opinion_yes_{{ $item->id }}"
                                                                        value="yes" class="vote">
                                                                    {{ languageStatus() == 'en' ? 'Yes' : 'হ্যাঁ' }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="radio">
                                                                <label class="vote">
                                                                    <input type="radio" name="poll_opinion"
                                                                        id="poll_opinion_no_{{ $item->id }}"
                                                                        value="no" class="vote">
                                                                    {{ languageStatus() == 'en' ? 'No' : 'না' }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="radio">
                                                                <label class="vote">
                                                                    <input type="radio" name="poll_opinion"
                                                                        id="poll_opinion_nocmnt_{{ $item->id }}"
                                                                        value="no_comment" class="vote">
                                                                    {{ languageStatus() == 'en' ? 'No Comment' : 'মন্তব্য নেই' }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if (CommonFunction::isPollingEligible($item->id))
                                                    <a class="nfis-sec-btn vote"
                                                        onclick="poolingAction({{ $item->id }})"
                                                        id="poolingActionBtn_{{ $item->id }}">{{ languageStatus() == 'en' ? 'Vote' : 'ভোট' }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="nfis-pagination">
                                    <div class="d-flex justify-content-center my-5">
                                        {!! $polls->links() !!}
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </section>
        
    @endsection

    @section('script')
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
        <script>
            function poolingAction(poll_id) {
                let poll_opinion = ''
                if (document.getElementById('poll_opinion_yes_' + poll_id).checked) {
                    poll_opinion = 'yes';
                } else if (document.getElementById('poll_opinion_no_' + poll_id).checked) {
                    poll_opinion = 'no';
                } else if (document.getElementById('poll_opinion_nocmnt_' + poll_id).checked) {
                    poll_opinion = 'no_comment';
                }

                if (!poll_opinion) {
                    toastr.warning("Please select your opinion!")
                    return
                }
                $.ajax({
                    url: "{{ route('pooling_action') }}",
                    type: "post",
                    data: {
                        poll_id: poll_id,
                        poll_opinion: poll_opinion,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        if (response.status == 'failed') {
                            toastr.error(response.message)
                        } else {
                            toastr.success(response.message)
                        }
                        $("#poolingActionBtn_" + poll_id).hide();
                    },
                    error: function error(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

            // poolingAction ()
        </script>
    @endsection
