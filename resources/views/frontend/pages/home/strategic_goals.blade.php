<section id="nfisStrategicGoal" class="nfis-goal-ring-sec mt-5" style="background-image:url({{ asset('images/ring-sec-bg.webp') }})">
    <div class="container">
        <div class="nfis-ring-content">
            <div class="nfis-sec-title">
                <div class="flex-title-justify">
                    <h2>{{ languageStatus() == 'en' ? 'Strategic Goals' : "কৌশলগত লক্ষ্য" }}</h2>
                </div>
            </div>
            <div class="nfis-ring-container">
                <div class="sdg-wheel-wrap">
                    <div id="nfisRing" class="c-ring">
                        <div class="center-image" style="background-color: #F0F2F5;"></div>
                    </div>
                </div>

                <div class="dsp sdg-content-wrap">
                    <div class="nfis-goal-ring-content">
                        <div class="sdg-ring-content-description"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="block-iom-content" class="block block-system block-system-main-block">
            <div class="container">
                <div class="view view-sdg view-id-sdg view-display-id-page_1">
                    <div class="view-content">

                        @foreach($goals  as $goal)
                            <div class="sdg-node sdg-{{ $goal->order }} sdg-node-hidden views-row">
                                <div class="full-content field__image">
                                    <div class="nfis-ring-circle-img">
                                        <img src="{{ asset($goal->bg_image) }}" alt="{{ $goal->title_en }}">
                                    </div>
                                </div>
                                <div class="sdg-content-description">
                                    <div class="nfis-ring-desc-wrap" style="background-color: {{ $goal->hex_color }};">
                                        <div class="nfis-ring-desc">
                                            <div class="ring-desc-head">
                                                <h2>
                                                    {{ languageStatus() == 'en' ? 'Strategic Goal' : "কৌশলগত লক্ষ্য" }} {{ languageStatus() == 'en' ? $goal->order : \App\Libraries\CommonFunction::convert2Bangla($goal->order) }}
                                                </h2>
                                                <h2 class="text-center ring-target-num">
                                                    <span>{{ languageStatus() == 'en' ? $goal->target : \App\Libraries\CommonFunction::convert2Bangla($goal->target) }}</span>

                                                    {{ languageStatus() == 'en' ? 'Targets' : "টার্গেট" }}
                                                </h2>
                                            </div>
                                            <div class="ring-desc-footer">
                                                <h3>{{ languageStatus() == 'en' ? ($goal->title_en??null) : ($goal->title_bn??null ) }}</h3>
                                                <a class="nfis-sec-btn" href="{{ route('frontend.strategicGoals') }}">  {{ languageStatus() == 'en' ? 'Details' : "বিস্তারিত" }} <span class="icon-btn-arrow-clr"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
