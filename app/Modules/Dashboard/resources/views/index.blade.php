@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
    <link rel="stylesheet"  href="{{ asset('plugins/simple-calendar/simple-calendar.css') }}" />
@endsection

@section('content')

    <div class="row dashboard-card">
        <div class="col-md-6">

            {{-- Schedule calendar --}}
            <div class="card collapsed-card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Schedule calendar
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="schedule_calendar"></div>
                </div>
            </div>

            {{-- Notice Board --}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Notice Board
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="notice_list" class="table table-striped table-bordered dt-responsive " cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Publish Date</th>
                                <th>Achieve Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Interpretation of Integrated Index Score --}}
            @if ((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Interpretation of Integrated Index Score
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="load_interpretation_div"></div>
                    </div>
                </div>
            </div>
            @endif

        </div>


        <div class="col-md-6">

            {{-- Schedule details --}}
            <div class="card collapsed-card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Schedule details
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body schedule-data">
                    @foreach($schedule_data as $data)
                        <div class="row">
                            <div class="col-4">
                                <div class="date d-flex">
                                    <p ><i class="fas fa-calendar-alt"></i> <span>{{ Carbon\Carbon::createFromFormat('Y-m-d', strval($data->start_date))->format('d M Y') }}</span></p>
                                </div>
                                <div class="time">
                                    <p class="time">
                                        @if(isset($data->start_time))
                                            {{ Carbon\Carbon::createFromFormat('H:i:s', strval($data->start_time))->format('h:i A') }}
                                        @endif
                                        @if($data->end_time)
                                            -
                                            {{ Carbon\Carbon::createFromFormat('H:i:s', strval($data->end_time))->format('h:i A') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="schedule-info">
                                    <h5 class="title"><a download target="_blank" href="/{{ $data->attachment ?? '#' }}"><i class="fas fa-check-square"></i>  <span>{{ $data->title }}</span></a> </h5>
                                    <p class="details"> {{ Str::limit($data->description, 80) }} </p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                        <div>
                            <a href="{{ route('communications.list') }}" class="btn btn-sm btn-info mt-3 float-right"> More </a>
                        </div>




                </div>
            </div>

            {{-- Organization Wise Data --}}
            @if ((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Organization Wise Data
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                            {!! Form::select('year', mefBankYears(), 2010, [
                            'id' => 'year',
                            'onchange' => 'organizationWiseDataDashboard()',
                            'class' => 'form-control required',
                            ]) !!}
                        </div>
                        <div class="form-group col-6">
                            {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                            {!! Form::select('quarter', quarters(), 1, [
                            'id' => 'quarter',
                            'onchange' => 'organizationWiseDataDashboard()',
                            'class' => 'form-control required',
                            ]) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div id="load_data_div"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('footer-script')
@include('partials.datatable-js')
<script type="text/javascript" src="{{ asset('plugins/simple-calendar/jquery.simple-calendar.min.js')}}"></script>
<script>
    $(function() {
        $('#notice_list').DataTable({
            searching: false, paging: false, info: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('notices.data') }}',
                method: 'post',
                data: function(d) {
                    d._token = $('input[name="_token"]').val();
                },
                error: function(xhr, error, thrown) {
                    debugger
                    let errorMessage = 'An error occurred while fetching data. Please try again later.';
                    if (thrown) {
                        errorMessage = thrown;
                    }
                    $('#list').html('<div class="alert alert-warning" role="alert">' + errorMessage + '</div>');
                    $(".dataTables_processing").hide()
                }
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row+1;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'publish_at',
                    name: 'publish_at'
                },
                {
                    data: 'achieve_at',
                    name: 'achieve_at'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "aaSorting": []
        });

        $("#schedule_calendar").simpleCalendar({
            displayEvent: true,
            events: [
                    @foreach($communications as $data)
                {
                    "startDate": "{{$data->start_date}}",
                    "endDate": "{{$data->end_date}}",
                    "summary": "<a target='_blank' href='/{{ $data->attachment ?? '#' }}'><span>{{ $data->title }}<\/span><\/a> "
                },
                @endforeach

            ],
        });


    });


    function organizationWiseDataDashboard() {
        let quarter = document.getElementById("quarter").value;
        let year = document.getElementById("year").value;
        if (!quarter && !year) {
            return;
        }

        $.ajax({
            url: "{{ route('organization_wise_data_dashboard') }}",
            type: "get",
            data: {
                quarter: quarter,
                year: year,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                $("#load_data_div").html(data);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    setTimeout(organizationWiseDataDashboard, 0);

    $(document).on("click", ".organizationListModalBtn", function () {
        let action = $(this).data('action');
        let organizations = $(this).data('organizations');
        $(".load_org_data_div").html('No Data Found!!');
        if (action == 'approved') {
            $(".modal_label_div").html('Approved List');
        } else if (action == 'unapproved') {
            $(".modal_label_div").html('Not Approved List');
        } else if (action == 'not_provided') {
            $(".modal_label_div").html('Not Provided List');
        }

        if (organizations.length < 1) {
            return;
        }
        let list_data = "";
        $.ajax({
            url: "{{ route('organization_info') }}",
            type: "get",
            data: {
                organizations: organizations,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                data.forEach(function (item) {
                    list_data += "<li>" + item + "</li>";
                });
                $(".load_org_data_div").html(list_data);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });



    function integratedIndexScoreDashboard() {

        $.ajax({
            url: "{{ route('integrated_index_score') }}",
            type: "get",
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                $("#load_interpretation_div").html(data);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    setTimeout(integratedIndexScoreDashboard, 0);


    function scoreRecordPublishAction(year, quarter, indicator_score, goal_tracking_score) {
        if (!quarter && !year) {
            return;
        }

        $.ajax({
            url: "{{ route('score_record_publish') }}",
            type: "get",
            data: {
                quarter: quarter,
                year: year,
                indicator_score: indicator_score,
                goal_tracking_score: goal_tracking_score,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                window.location.reload();
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

</script>
@endsection
