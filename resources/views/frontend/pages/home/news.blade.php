<section class="home-news-sec">
    <div class="container">
        <div class="nfis-news-content">
            <div class="nfis-sec-title">
                <h2>{{ languageStatus() == 'en' ? 'Recent News' : "সাম্প্রতিক খবর" }}</h2>
            </div>
            @if ($article->toArray())
                <div class="row">
                    @foreach ($article as $single_article)
                        <div class="col-lg-4 nfis-col-mb">

                            <a href="{{ route('frontend.news.show',['id' => Encryption::encodeId($single_article->id)]) }}"
                               class="news-inline-item">
                                <div class="news-inline-photo"
                                     style="background-image: url({{ asset(CommonFunction::setImageOrDefault($single_article->image??null)) }});"
                                     onerror="this.src=`{{asset('images/no_image.webp')}}`"></div>
                                <div class="news-inline-desc">
                                    <p>{{ languageStatus() == 'en' ? Str::limit($single_article->title_en??null, 80) : Str::limit($single_article->title_bn??null, 80) }}</p>
                                    <span class="news-inline-date">
                                        {{ !empty($single_article->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($single_article->updated_at))) : date('d M, Y', strtotime($single_article->updated_at)) : null }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="event-sec-btn">
                <a class="nfis-sec-btn" href="{{ route('frontend.news.list') }}">{{ languageStatus() == 'en' ? 'More News' : "আরও খবর" }}
                    <span class="icon-btn-arrow-clr"></span>
                </a>
            </div>
        </div>
    </div>
</section>
