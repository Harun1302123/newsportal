<section class="home-calendar-section">
    <div class="event-calendar-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="nfis-cal-info">
                        <div class="cal-desc">
                            <a class="calendar-btn" href="#">{{ languageStatus() == 'en' ? 'Event Calendar' : "ইভেন্ট ক্যালেন্ডার" }}</a>
                            <h2>{{ languageStatus() == 'en' ? $event->heading_en ?? null : ($event->heading_bn??null) }} </h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="nfis-cal-photo">
                        <img src="{{ asset($event->image ?? null )}}" alt="{{ languageStatus() == 'en' ? $event->heading_en ?? null : ($event->heading_bn??null) }}" onerror="this.src=`{{asset('images/no_image.webp')}}`">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="upc-events-date">
        <div class="">
            <div class="upc-cal-content">
                <div class="upc-event-title">
                    <h3>{{ languageStatus() == 'en' ? 'Events Name' : "ইভেন্টস নাম" }} <br><small>{{ languageStatus() == 'en' ? $event->heading_en ?? null : ($event->heading_bn??null) }}</small></h3>
                </div>
                <div class="upc-event-timer d-flex">
                    <div class="upc-event-date-day">
                        <span class="upc-ed-day">
                            <span hidden id="session_language">{{ languageStatus() }}</span>
                            {{ !empty($event->event_date) ? languageStatus() == 'bn' ? App\Libraries\CommonFunction::convertEnglishDateToBangla(date('d M', strtotime($event->event_date))) : date('d M', strtotime($event->event_date)) : null }}
                        </span>
                        <span id="event_date_time" class="hidden"> {{!empty($event->event_date) ? $event->event_date : null}} </span>
                    </div>
                    <div class="upc-event-time d-flex">
                        <div class="upc-event-time-item">
                            <span id="event-day" class="time-num"></span>
                            <span class="time-name">
                                {{ languageStatus() == 'en' ? 'Days' : "দিন" }}
                            </span>
                        </div>
                        <div class="upc-event-time-item">
                            <span id="event-hour" class="time-num"></span>
                            <span class="time-name">
                                {{ languageStatus() == 'en' ? 'Hour' : "ঘন্টা" }}
                            </span>
                        </div>
                        <div class="upc-event-time-item">
                            <span id="event-minute" class="time-num"></span>
                            <span class="time-name">
                                {{ languageStatus() == 'en' ? 'Minutes' : "মিনিট" }}
                            </span>
                        </div>
                        <div class="upc-event-time-item">
                            <span id="event-second" class="time-num"></span>
                            <span class="time-name">
                                 {{ languageStatus() == 'en' ? 'Second' : "সেকেন্ড" }}
                                </span>
                        </div>
                    </div>
                </div>

                <div class="event-sec-btn">
                    <a class="nfis-sec-btn" href="{{ route('frontend.event.list') }}">
                        {{ languageStatus() == 'en' ? 'All' : "সব" }}
                        <span class="icon-btn-arrow-clr"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
