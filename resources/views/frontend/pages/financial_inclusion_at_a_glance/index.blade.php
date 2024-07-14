@extends('frontend.layouts.master')
<style>
    .nfis-cal-info{
        display: inline;
    }
    .nfis-bio-msg span{
        font-size: 20px;
        font-weight: normal;
    }
    .details-body-2 .fi-box-item
    {
        margin: 10px;
    }
</style>
@section('content')
    <main class="site-main-content page-height">
        <div class="nfis-breadcrumb">
            <div class="container">
                <ul class="nfis-breadcrumb-lists">
                    <li class="nfis-bc-item bc-back-btn">
                        <a href="#">
                                <span class="bc-back-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <path opacity="0.4" d="M6.59015 11.3925C3.46604 11.3925 0.925408 8.85126 0.925408 5.72773C0.925408 2.60419 3.46604 0.0629883 6.59015 0.0629883C9.71368 0.0629883 12.2549 2.60419 12.2549 5.72773C12.2549 8.85126 9.71368 11.3925 6.59015 11.3925" fill="white"></path>
                                        <path d="M7.40704 8.11853C7.29884 8.11853 7.19008 8.07718 7.10738 7.99448L5.13208 6.02881C5.05221 5.94894 5.00746 5.84074 5.00746 5.72745C5.00746 5.61472 5.05221 5.50652 5.13208 5.42665L7.10738 3.45985C7.27335 3.29444 7.54186 3.29444 7.70784 3.46099C7.87325 3.62753 7.87268 3.89661 7.70671 4.06202L6.03391 5.72745L7.70671 7.39288C7.87268 7.55829 7.87325 7.8268 7.70784 7.99334C7.62513 8.07718 7.5158 8.11853 7.40704 8.11853" fill="white"></path>
                                    </svg>
                                </span>
                        </a>
                    </li>
                    <li class="nfis-bc-item"><a href="{{ route('frontend.home') }}">{{ languageStatus() == 'en' ? 'Home' : "হোম" }}</a></li>
                    <li class="nfis-bc-item active">{{ languageStatus() == 'en' ? 'Details' : "বিস্তারিত" }}</li>

                </ul>
            </div>
        </div>

        <section class="financial-inclusion-sec">
            <div class="container">
                <div class="nfis-content-container">
                    <div class="nfis-filter-block">
                        <div class="nfis-filter-container">
                            <div class="row">
                                <div class="col-lg-4 filter-col">
                                    {!! Form::select('organization_type_id', $organization_types,  old('organization_type_id', $financial_inclusion->organization_type_id ?? ''), ['class' => 'form-control organization_type_id select2 year required']) !!}
                                </div>
                                <div class="col-lg-4 filter-col">
                                    {!! Form::select('mef_year', $year,  old('mef_year', $financial_inclusion->mef_year ?? ''), ['class' => 'form-control select2 mef_year year required']) !!}
                                </div>
                                <div class="col-lg-4 filter-col">
                                    {!! Form::select('mef_quarter_id', $quarter,  old('mef_quarter_id', $financial_inclusion->mef_quarter_id ?? ''), ['class' => 'form-control mef_quarter_id select2 year required']) !!}
                                </div>
                            </div>
                            <div class="right-filter-btn">
                                <button class="btn-filter-title filter-btn">{{ languageStatus() == 'en' ? 'Filter' : "ফিল্টার" }} <span class="icon-filter"></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" id="financial_inclusion_data">
                        <h4>Filter with desire value........</h4>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Attach a click event handler to the button
            $('.filter-btn').click(function() {
                // Make an AJAX request using jQuery's $.ajax() method
                let organization_type_id = $(".organization_type_id").val()
                let mef_year = $(".mef_year").val()
                let mef_quarter_id = $(".mef_quarter_id").val()

                if(organization_type_id !== null && mef_year !== null && mef_quarter_id !== null)
                {
                    $.ajax({
                        type: 'POST',
                        url: '/financial-inclusion-at-a-glance/details',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            organization_type_id: organization_type_id,
                            mef_year: mef_year,
                            mef_quarter_id: mef_quarter_id,
                        },
                        success: function(response) {
                            $('#financial_inclusion_data').html(response);
                        },
                        error: function() {
                            // Handle errors if needed
                            $('#financial_inclusion_data h4').text('Error loading the page.');
                        }
                    });
                }
                else
                {
                    $('#financial_inclusion_data h4').text('All the field are required');
                }







            });

            $('.filter-btn').trigger('click')
        });
    </script>
@endsection
