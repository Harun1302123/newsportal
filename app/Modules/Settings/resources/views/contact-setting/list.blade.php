@extends('layouts.admin')

@section('content')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Contact Setting List</h3>
                    <!-- /.card-tools -->
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <tr style="background: #17a2b8;  color: #fff">
                                            <th colspan="2" class="">General Settings</th>
                                        </tr>
                                        <tr>
                                            <th>Logo</th>
                                            <td><img src="{{asset($data->logo)}}" alt="" width="100" height="100"></td>
                                        </tr>

                                        <tr>
                                            <th>Manage By</th>
                                            <td>{{$data->manage_by}}</td>
                                        </tr>
                                        <tr>
                                            <th>Associate</th>
                                            <td>{{$data->associate}}</td>
                                        </tr>

                                        <tr>
                                            <th>Suppot Link</th>
                                            <td>{{$data->support_link}}</td>
                                        </tr>

                                        <tr>
                                            <th>At a glance link</th>
                                            <td>{{$data->at_a_glance_link}}</td>
                                        </tr>

                                    </table>
                                </div><!-- /.table-responsive -->
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                       width="100%">
                                    <tr style="background: #17a2b8; color: #fff">
                                        <th colspan="2" class="">Contact Information</th>
                                    </tr>
                                    <tr>
                                        <th>Contact Person One Name</th>
                                        <td>{!! $data->contact_person_one_name_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person One Designation</th>
                                        <td>{!! $data->contact_person_one_designation_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person One Phone</th>
                                        <td>{!! $data->contact_person_one_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person One Email</th>
                                        <td>{!! $data->contact_person_one_email !!}</td>
                                    </tr>


                                    <tr>
                                        <th>Contact Person Two Name</th>
                                        <td>{!! $data->contact_person_two_name_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Two Designation</th>
                                        <td>{!! $data->contact_person_two_designation_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Two Phone</th>
                                        <td>{!! $data->contact_person_two_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Two Email</th>
                                        <td>{!! $data->contact_person_two_email !!}</td>
                                    </tr>


                                    <tr>
                                        <th>Contact Person Three Name</th>
                                        <td>{!! $data->contact_person_three_name_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Three Designation</th>
                                        <td>{!! $data->contact_person_three_designation_en !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Three Phone</th>
                                        <td>{!! $data->contact_person_three_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person Three Email</th>
                                        <td>{!! $data->contact_person_three_email !!}</td>
                                    </tr>

                                </table>
                            </div><!-- /.table-responsive -->
                        </div>
                    </div>

                </div><!-- /.panel-body -->
                <div class="card-footer">
                    <div class="float-left">

                    </div>
                    <div class="float-right">
                        @if($edit_permission)
                            <a href="{{url('contact-setting/edit')}}" class="btn btn-primary float-right"><i class="fa fa-chevron-circle-right"></i> Edit</a>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.panel -->
@endsection
<!--content section-->


