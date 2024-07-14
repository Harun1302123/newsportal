<?php
//ob#code@start - (galib) from controller
$user_type = Auth::user()->user_type;
$type = explode('x', $user_type);
?>
<style>
    .radio_label {
        cursor: pointer;
    }

    .small-box {
        margin-bottom: 0;
        cursor: pointer;
    }

    @media (min-width: 481px) {
        .g_name {
            font-size: 32px;
        }
    }

    @media (max-width: 480px) {
        .g_name {
            font-size: 18px;
        }

        span {
            font-size: 14px;
        }

        label {
            font-size: 14px;
        }
    }

    @media (min-width: 767px) {
        .has_border {
            border-left: 1px solid lightgrey;
        }

        .has_border_right {
            border-right: 1px solid lightgrey;
        }
    }
</style>

@if (isset($services) && in_array($type[0], [1, 4]))

    <div class="row mb-4">

        @foreach ($services as $service)
            <div class="col-lg-3 col-6">
                <div class="small-box bg-{{ !empty($service->panel) ? $service->panel : 'info' }}">
                    <div class="inner">
                        <h3> {{ !empty($service->totalApplication) ? $service->totalApplication : '0' }}</h3>
                        <p>{{ !empty($service->name_bn) ? $service->name_bn : 'N/A' }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas {{ $service->icon }}"></i>
                    </div>
                    <a class="small-box-footer"
                        href="{{ !empty($service->form_url) && $service->form_url == '/#' ? 'javascript:void(0)' : url($service->form_url . '/list/' . \App\Libraries\Encryption::encodeId($service->id)) }}"
                        {{ !empty($service->form_url) && $service->form_url != '/#' ? 'target="_blank"' : '' }}>
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endforeach

    </div>

@endif


@if (Auth::user()->user_type == '5x505')
    <section>
        @if (!empty($userApplicaitons))
            <div class="row">
                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">

                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'draftButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="draftButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['draft'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #7C5CF5, #9B8BF7); border-radius: 10px; padding: 10px; height: 100%;margin-bottom:0;max-width:60px">
                                    <img src="/assets/images/notebook.svg" alt="" height="50%">
                                </div>
                            </div>
                            <input type="hidden" name="search_by_keyword" required class="form-control"
                                placeholder="Search by keywords" value="dashboard-search@@@ -1">
                            {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600; margin-bottom:0">Draft
                                    Application</p>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">
                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'progressButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="progressButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['processing'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #69D4D4, #6CD2D5); border-radius: 10px; padding: 15px; height: 100%; max-width: 60px;">
                                    <img src="/assets/images/process.svg" alt="" height="50%">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600;margin-bottom:0">Process
                                    Application</p>
                            </div>
                        </div>
                        <input type="hidden" name="search_by_keyword" required class="form-control"
                            placeholder="Search by keywords"
                            value="dashboard-search@@@ 1, 2, 9, 15, 16, 8, 10, 9">
                        {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        {!! Form::close() !!}
                    </div>
                </div>

                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">
                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'approvedButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="approvedButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['approved'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #5373DF, #458DDD); border-radius: 10px; padding: 10px; height: 100%;margin-bottom:0;max-width:60px">
                                    <img src="/assets/images/approval.svg" alt="" height="50%">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600;margin-bottom:0">Approved
                                    Application</p>
                            </div>
                        </div>
                        <input type="hidden" name="search_by_keyword" required class="form-control"
                            placeholder="Search by keywords" value="dashboard-search@@@ 25">
                        {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        {!! Form::close() !!}
                    </div>
                </div>


                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">
                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'shortfallButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="shortfallButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['shortfallapp'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #5373DF, #458DDD); border-radius: 10px; padding: 10px; height: 100%;margin-bottom:0;max-width:60px">
                                    <img src="/assets/images/approval.svg" alt="" height="50%">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600;margin-bottom:0">Shortfall
                                    Application</p>
                            </div>
                        </div>
                        <input type="hidden" name="search_by_keyword" required class="form-control"
                            placeholder="Search by keywords" value="dashboard-search@@@ 5">
                        {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        {!! Form::close() !!}
                    </div>
                </div>

                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">
                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'rejectedButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="rejectedButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['rejectapp'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #5373DF, #458DDD); border-radius: 10px; padding: 10px; height: 100%;margin-bottom:0;max-width:60px">
                                    <img src="/assets/images/approval.svg" alt="" height="50%">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600;margin-bottom:0">Rejected
                                    Application</p>
                            </div>
                        </div>
                        <input type="hidden" name="search_by_keyword" required class="form-control"
                            placeholder="Search by keywords" value="dashboard-search@@@ 6">
                        {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        {!! Form::close() !!}
                    </div>
                </div>


                <div style='cursor: pointer;' class="form-group col-lg-3 col-md-3 col-6">
                    <div class="small-box" style="background: white; border-radius: 10px; padding: 15px;">
                        {!! Form::open([
                            'url' => '/process/list',
                            'method' => 'POST',
                            'class' => 'othersButtonForm',
                            'id' => '',
                            'role' => 'form',
                        ]) !!}
                        <div class="row" id="othersButton">
                            <div class="col-md-8 col-6">
                                <p
                                    style="color: #452A73; font-size: 34px; font-weight: 600; margin-bottom:0; line-height:60px">
                                    {{ $userApplicaitons['totalapp'] }}</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="small-box"
                                    style="align-items: center; justify-content: center; background-image: linear-gradient(to right, #EC6060, #FC8170); border-radius: 10px; padding: 10px; height: 100%;margin-bottom:0;max-width:60px">
                                    <img src="/assets/images/list-text.svg" alt="" height="50%">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="color: #452A73; font-size: 16px; font-weight: 600;margin-bottom:0">Total
                                    Application</p>
                            </div>
                        </div>
                        <input type="hidden" name="search_by_keyword" required class="form-control"
                            placeholder="Search by keywords"
                            value="dashboard-search@@@ -1,1,2,5,6,25">
                        {{-- Input value dashboard-search@@@ fixed for dashboard search --}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif

{{--        @if ( (Auth::user()->working_company_id == 0 && count($check_association_from) == 0) || $is_eligibility == 0 )--}}

{{--            @include('CompanyAssociation::company-association-form')--}}
{{--        @endif--}}

        @include('CompanyAssociation::pending-approval-panel')

    </section>
@endif

@if(Auth::user()->user_type == 1 || Auth::user()->user_role_id != 0)
    @if (Auth::user()->user_type == '5x505' && !empty($servicesWiseApplication) && Auth::user()->working_company_id != 0)
        @if($is_eligibility == 1)
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <p style="font-size: 28px">{!! trans('Dashboard::messages.services') !!}</p>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    @foreach ($servicesWiseApplication as $item)
                        @if ($item->group_name != null)
                            <div class="form-group col-md-3 col-lg-3 col-6">
                                <div class="panel-body text-center"
                                     style="background: white; border-radius: 7px; box-shadow: 5px 5px 5px #D4D5D6; padding: 25px">
                                    <img src="/assets/images/passport.png" alt="" style="width: 45px"><br>
                                    <p class="g_name">{{ $item->group_name }}</p>
                                    {{-- <p style="font-size: 22px; color: #9F9FB8">{!!trans('Dashboard::messages.new_application')!!}</p> --}}
                                    <br>
                                    <a class="btn btn-sm" style="color: white; background: #452A73"
                                       href="/client/process/details/{{ \App\Libraries\Encryption::encode($item->group_name) }}">আবেদন</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


            </section>
        @endif
    @endif
@else
    <div class="alert alert-danger">You have no permission yet, please contact with system admin or go to <a
            href="{{url('/')}}">Homepage</a></div>
@endif




<?php
$desk_id_array = explode(',', \Session::get('user_desk_ids'));
?>

@section('chart_script')
    @if (!empty($map_script_array))
        {{-- @include('partials.amchart-js') --}}
        <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

        @foreach ($map_script_array as $script)
            <script type="text/javascript">
                $(function() {
                    <?php echo $script; ?>
                });
            </script>
        @endforeach
    @endif

@endsection

<script>
    function approveAndRejectCompanyAssoc(e, key) {
        var r = confirm("Are you sure?");
        if (r !== true) {
            return false;
        }
        e.disabled = true;
        const button_text = e.innerText;
        const loading_sign = '...<i class="fa fa-spinner fa-spin"></i>';

        var companyAssocId = e.value;
        var type = $("input:radio[name='userType']:checked").val()

        $.ajax({
            url: "{{ url('client/company-association/approve-reject') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                companyAssocId: companyAssocId,
                type: type,
                key: key,
            },
            beforeSend: function() {
                e.innerHTML = button_text + loading_sign;
            },
            success: function(response) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.warning('Yor approval was not successful!');
                console.log(errorThrown);
            },
            complete: function() {
                toastr.success('Yor approval was successful!');
            }
        });
    }
</script>

<script type="text/javascript" src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>


<script type="text/javascript">
    $('#draftButton').click(function() {
        $('.draftButtonForm').submit();
    });

    $('#progressButton').click(function() {
        $('.progressButtonForm').submit();
    });

    $('#approvedButton').click(function() {
        $('.approvedButtonForm').submit();
    });
    $('#othersButton').click(function() {
        $('.othersButtonForm').submit();
    });

    $('#shortfallButton').click(function() {
        $('.shortfallButtonForm').submit();
    });

    $('#rejectedButton').click(function() {
        $('.rejectedButtonForm').submit();
    });

</script>
