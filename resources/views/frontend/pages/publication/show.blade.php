@extends('frontend.layouts.master')

@section('content')
    <main class="site-main-content page-height">
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
                    <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Publication Details' : "পাবলিকেশন বিবরণ" }}</li>
                </ul>
            </div>
        </div>


        <div class="nfis-post-content nfis-publication">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="row flex-wrap-reverse" style="row-gap: 50px">
                        <div class="col-lg-4">
                            <div class="nfis-post-sidebar">
                                <div class="widget-item">
                                    <h3>{{ languageStatus() == 'en' ? 'Related Publication' : "সম্পর্কিত পাবলিকেশন" }}</h3>
                                    @foreach($related as $single_related)
                                        <a href="{{route('frontend.publication.show', ['id' => Encryption::encodeId($single_related->id)])}}" class="post-lists-item">
                                            <div class="post-list-img" style="background-image: url('{{ asset(CommonFunction::setImageOrDefault($single_related->image??null)) }}')"></div>
                                            <div class="post-list-desc">
                                                <h4>{{ languageStatus() == 'en' ? Str::limit($single_related->title_en??null, 80) : Str::limit($single_related->title_bn??null, 80) }}</h4>
                                                <span class="date-text">{{ !empty($single_related->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($single_related->updated_at))) : date('d M, Y', strtotime($single_related->updated_at)) : null }}</span>

                                            </div>
                                        </a>
                                    @endforeach

{{--                                    <div class="nfis-pagination">--}}
{{--                                        <div class="d-flex justify-content-center ">--}}
{{--                                            {!! $related->links() !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="nfis-post-details">
                                <div class="nfis-post-title">
                                    <h3>{{ languageStatus() == 'en' ? ($publication->title_en??null) : ($publication->title_bn??null) }}</h3>
                                    <span class="date-text">{{ !empty($publication->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($publication->updated_at))) : date('d M, Y', strtotime($publication->updated_at)) : null }}</span>


                                </div>
                                <div class="single-photo-item">
                                    <img src="{{ asset(CommonFunction::setImageOrDefault($publication->image??null)) }}" alt="Images">
                                </div>
                                <p>{!! languageStatus() == 'en' ? $publication->details_en??null : $publication->details_bn??null !!}</p>
                                @if($publication->attachment)
                                    <a class="btn btn-info" href="{{ asset($publication->attachment) }}" download>Download <i class="fas fa-download"></i></a>
                                @endif

                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('script')
@endsection
