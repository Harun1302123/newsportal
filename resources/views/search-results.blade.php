@section('header-resources')
    <style>
        .suggestion {
            padding: 10px;
            background-color: #fff;
        }
    </style>
@endsection

<div class="sdg-search-wrap" style="max-height: 250px;margin-top: 50px" >
    <div class='suggestion' style="margin-top: -30px;" id="suggestion_search">
        @if($photo_galleries)
        @foreach ($photo_galleries as $photo_gallery)
           <b>{{ languageStatus() == 'en' ? 'Photo Gallery:' : "ফটো গ্যালারি:" }}</b> <a href="{{ route('frontend.photoGalleries.list',['id' => Encryption::encodeId($photo_gallery->id)]) }}">{{ languageStatus() == 'en' ? $photo_gallery->title_en : $photo_gallery->title_bn}}</a> <br><br>
        @endforeach
        @endif

        @if($biographies)
           @foreach ($biographies as $biography)
            <b>{{ languageStatus() == 'en' ? 'Biography:' : "জীবনী:" }}</b> <a href="{{ route('frontend.biography.detail',['id' => Encryption::encodeId($biography->id)]) }}">{{ languageStatus() == 'en' ? $biography->name_en : $biography->name_bn}}</a> <br><br>
           @endforeach
        @endif

        @if($articles)
        @foreach ($articles as $article)
            <b> {{ languageStatus() == 'en' ? 'Recent News:' : "সাম্প্রতিক খবর:" }}</b> <a href="{{ route('frontend.news.show',['id' => Encryption::encodeId($article->id)]) }}">{{ languageStatus() == 'en' ? $article->title_en : $article->title_bn}}</a> <br><br>
        @endforeach
        @endif

        @if($video_galleries)
        @foreach ($video_galleries as $video_gallery)
            <b> {{ languageStatus() == 'en' ? 'Video:' : "ভিডিও:" }}</b> <a href="{{ route('frontend.videoGalleries.list',['id' => Encryption::encodeId($video_gallery->id)]) }}">{{ languageStatus() == 'en' ? $video_gallery->title_en : $video_gallery->title_bn}}</a> <br><br>
        @endforeach
        @endif

        @if($goals)
        @foreach ($goals as $goal)
            <b>{{ languageStatus() == 'en' ? ' Goals:' : " লক্ষ্য:" }}</b> <a href="{{ route('frontend.strategicGoals',['id' => Encryption::encodeId($goal->id)]) }}">{{ languageStatus() == 'en' ? $goal->title_en : $goal->title_bn}}</a> <br><br>
        @endforeach
        @endif

        @if($indicators)
        @foreach ($indicators as $indicator)
            <b>{{ languageStatus() == 'en' ? 'Indicators' : 'সূচক'}}:</b> <a href="{{ route('frontend.mAndeFramework',['id' => Encryption::encodeId($indicator->id)]) }}">{{ languageStatus() == 'en' ? $indicator->name : $indicator->name_bn}}</a> <br><br>
        @endforeach
        @endif

        @if($targets)
        @foreach ($targets as $target)
            <b>{{ languageStatus() == 'en' ? 'Target' : 'টার্গেট'}}:</b> <a href="{{ route('frontend.strategicGoals',['id' => Encryption::encodeId($target->id)]) }}">{{ languageStatus() == 'en' ? $target->title_en : $target->title_bn}}</a> <br><br>
        @endforeach
        @endif
    </div>
</div>
