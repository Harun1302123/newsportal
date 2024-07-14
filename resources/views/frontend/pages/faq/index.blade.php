@extends('frontend.layouts.master')


@section('content')
    <div class="main-page-content">
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

                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'FAQ' : "এফএকিউ" }}</li>
                </ul>
            </div>
        </div>
        <section class="sdg-faq-page pb-5">
            <div class="container">
                <div class="sdg-faq-page-content pt-4">
                    <div class="sdg-sec-title">
                        <h2>{{ languageStatus() == 'en' ? 'FAQ' : "এফএকিউ" }}</h2>
                    </div>

                    <div id="sdgFaqAccordian" class="sdg-faq-accordian">
                        @php $sl = 0; @endphp
                        @foreach($faqs as $faq)
                            @php $sl = $sl + 1; @endphp
                            <div class="indicator-acd-item">
                                <div class="accordian-head @if($sl != 1) collapsed  @endif" data-toggle="collapse" data-target="#faqAccordian-{{$sl}}" aria-expanded="true" aria-controls="faqAccordian-{{$sl}}">
                                    <span class="accordian-indicator"><span class="icon-plus"></span></span>

                                    <div class="indicator-acd-title">
                                        <h3>{{$faq->title}}</h3>
                                    </div>
                                </div>
                                <div id="faqAccordian-{{$sl}}" class="collapse {{$sl == 1 ? 'show' : ''}}" data-parent="#sdgFaqAccordian">
                                    <div class="indicator-acd-content">
                                        <p>{{$faq->details}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var heading = document.getElementById('heading1');
            var isCollapseAlwaysShown = document.querySelector('.collapse.show');
            var button = heading.querySelector('button');
            var icon = button.querySelector('i');

            if (isCollapseAlwaysShown) {
                var title = heading.querySelector('.title-collapse');
                heading.style.backgroundColor = '#318DDE';
                title.style.color = 'white';
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
                button.style.backgroundColor = '#318DDE';
                icon.style.color = 'white';
            }

        });

        function toggleCollapse(headingId) {
            var heading = document.getElementById(headingId);
            var button = heading.querySelector('button');
            var icon = button.querySelector('i');
            var title = heading.querySelector('.title-collapse');
            var isCollapseAlwaysClose = document.querySelector('.collapse.show');

            if (icon.classList.contains('fa-plus')) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
                button.style.backgroundColor = '#318DDE';
                icon.style.color = 'white';
                heading.style.backgroundColor = '#318DDE';
                title.style.color = 'white';

                if (isCollapseAlwaysClose) {
                    var previousHeading = isCollapseAlwaysClose.parentNode.querySelector('.card-header');
                    var previousButton = previousHeading.querySelector('button');
                    var previousIcon = previousButton.querySelector('i');
                    var previousTitle = previousHeading.querySelector('.title-collapse');

                    previousIcon.classList.remove('fa-minus');
                    previousIcon.classList.add('fa-plus');
                    previousButton.style.backgroundColor = '';
                    previousIcon.style.color = '#318DDE';
                    previousHeading.style.backgroundColor = '';
                    previousTitle.style.color = '';
                    isCollapseAlwaysClose.classList.remove('show');
                }
            } else {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
                button.style.backgroundColor = '';
                icon.style.color = '#318DDE';
                heading.style.backgroundColor = '';
                title.style.color = '';
            }
        }
    </script>
@endsection


