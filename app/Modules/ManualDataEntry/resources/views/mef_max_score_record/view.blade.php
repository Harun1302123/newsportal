@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
    <div class="row">
        @php

        @endphp
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>Maximux Score Record Preview</strong></h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <div class="row">
                                <label class="col-lg-2 text-left">Year</label>                                
                                <div class="col-md-10">
                                    {{ $master_data->year ?? null }}
                                </div>
                            </div>
                        </div> 

                        <div class="form-group col-md-12">
                            <div class="row">
                                <label class="col-lg-2 text-left">Quarter</label>                                
                                <div class="col-md-10">
                                    {{ $master_data->mefQuarter->name ?? null }}
                                </div>
                            </div>
                        </div> 

                        <div class="form-group col-md-12">
                            <div class="row">
                                <label class="col-lg-2 text-left">Without Goal 12</label>                                
                                <div class="col-md-10">
                                    {{ $master_data->without_goal_12 ?? null }}
                                </div>
                            </div>
                        </div> 
                        <div class="form-group col-md-12">
                            <div class="row">
                                <label class="col-lg-2 text-left">Goal 12</label>                                
                                <div class="col-md-10">
                                    {{ $master_data->goal_12 ?? null }}
                                </div>
                            </div>
                        </div> 

                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route($list_route) }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                            Close
                        </a>
                    </div>
                    <div class="float-right">

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection <!--content section-->
