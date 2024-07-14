@if ($publications->toArray())
    <div class="row">
        @foreach ($publications as $data)
            <div class=" col-md-6 col-lg-4  gallery-col">
                <div class="nfis-news-item">
                    <div class="news-item-img"
                         style="background-image: url({{ asset(CommonFunction::setImageOrDefault($data->image??null)) }});"
                         onerror="this.src=`{{asset('images/no_image.png')}}`"></div>
                    <div class="news-item-desc">
                        <span class="date-meta">{{ !empty($data->updated_at) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M, Y', strtotime($data->updated_at))) : date('d M, Y', strtotime($data->updated_at)) : null }}</span>
                        <h5>{{ languageStatus() == 'en' ? Str::limit($data->title_en??null, 80) : Str::limit($data->title_bn??null, 80) }}</h5>
                        <p>{{ languageStatus() == 'en' ? (Str::limit(strip_tags($data->description_en), 80)??null) :(Str::limit(strip_tags($data->description_bn),80)??null) }}</p>
                    </div>
                    <div class="sec-seemore-group">
                        <a class="nfis-sec-btn"
                           href="{{ route('frontend.publication.show',['id' => Encryption::encodeId($data->id)]) }}">{{ languageStatus() == 'en' ? 'Details' : "বিস্তারিত" }}
                            <span class="icon-btn-arrow-clr"></span></a>
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
