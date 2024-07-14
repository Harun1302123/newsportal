@extends('layouts.admin')
@section('header-resources')
    @include('partials.datatable-css')
    <style>
        .small-box {
            margin-bottom: 0;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-magenta border border-magenta">

                <div class="card-header">
                    <div class="float-left"></div>
                    <div class="float-right">
                            @if($add_permission)
                                <a class="" href="{{ url('/reportv2/create') }}">
                                    {!! Form::button('<i class="fa fa-plus"></i> <b>Add New Report</b>', array('type' => 'button', 'class' => 'btn btn-default')) !!}
                                </a>
                            @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="card-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a data-toggle="tab" class="nav-link active" href="#list_1" aria-expanded="true">
                                    <b>Recent</b>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#list_2" aria-expanded="true">
                                    <b>My Favourite</b>
                                </a>
                            </li>
                            <li class="nav-item all_reports">
                                <a class="nav-link" data-toggle="tab" href="#list_3" aria-expanded="false">
                                    <b>All Reports</b>
                                </a>
                            </li>
                            <li class="nav-item unpublished_reports nav-link">
                                <a data-toggle="tab" href="#list_4" aria-expanded="false">
                                    <b>Unpublished</b>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="list_1" class="tab-pane active">
                            <div class="card card-default">
                                <div class="card-header">
                                    <label class="card-title" style="font-size: 18px;">Favourites</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    @foreach($favouriteReports as $favourite)
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <a href="{!! url('reportv2/view/'. Encryption::encode($favourite->report_id."/Favourites" )) !!}">
                                                <div class="small-box"
                                                     style="color: #fff; border-radius: 10px; padding: 15px; background-image: linear-gradient(to right, #7C5CF5, #9B8BF7);">
                                                    <div class=" text-center">
                                                        <i class="fa fa-file fa-3x"></i>
                                                    </div>
                                                    <br>
                                                    <div class=" text-center">
                                                        <label for="">{{$favourite->report_title}}</label>
                                                    </div>
                                                </div>
                                                </a>
                                            </div>

                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            @foreach($Categories as $row)
                                <?php
                                $singleData = explode('@', $row->groupData);
                                ?>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <label style="font-size: 18px;"
                                               class="card-title">{{$row->category_name}}</label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($singleData as $singleRow)
                                                <?php
                                                $value = explode('=', $singleRow);
                                                ?>

                                                <div class=" col-lg-3 col-md-3 col-xs-6 ">
                                                    <a href="{!! url('reportv2/view/'. Encryption::encode($value[0]."/Published" )) !!}">
                                                        <div class="small-box"
                                                             style="color: #fff; border-radius: 10px; padding: 15px; background-image: linear-gradient(to right, #69D4D4, #6CD2D5);">
                                                            <div class=" text-center">
                                                                <i class="fa fa-file fa-3x"></i>
                                                            </div>
                                                            <br>
                                                            <div class=" text-center">
                                                                <label for="">{{$value[1] ??""}}</label>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                            <div class="card panel-default">
                                <div class="card-header">
                                    <label class="card-title" style="font-size: 18px;">Uncategorized</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    @foreach($uncategorized as $item)
                                        <div class=" col-lg-3 col-md-3 col-xs-6">
                                            <a href="{!! url('reportv2/view/'. Encryption::encode($item->report_id."/Published" )) !!}">
                                                <div class="small-box"
                                                     style="color: #fff; border-radius: 10px; padding: 15px; background-image: linear-gradient(to right, #EC6060, #FC8170);">
                                                    <div class=" text-center">
                                                        <i class="fa fa-file fa-3x"></i>
                                                    </div>
                                                    <br>
                                                    <div class=" text-center">
                                                        <label for="">{{$item->report_title}}</label>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card panel-default">
                                <div class="card-header">
                                    <label class="card-title" style="font-size: 18px;">Published</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($publishedReports as $published)

                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <a href="{!! url('reportv2/view/'. Encryption::encode($published->report_id."/Published" )) !!}">
                                                    <div class="small-box"
                                                         style="color: #fff; border-radius: 10px; padding: 15px; background-image: linear-gradient(to right, #5373DF, #458DDD);">
                                                        <div class=" text-center">
                                                            <i class="fa fa-file fa-3x"></i>
                                                        </div>
                                                        <br>
                                                        <div class=" text-center">
                                                            <label for="">{{$published->report_title}}</label>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div id="list_2" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="fav_list" class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Last Modified</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($getFavouriteList['fav_report'] as $row)
                                            <tr>
                                                <td>{!! $row->report_title !!}</td>
                                                <td>{!! $row->category_name !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($row->updated_at)) !!}</td>
                                                <td>
                                                    @if(\App\Libraries\UtilFunction::isAllowedToViewFvrtReport($row->report_id))
                                                        @if(ACL::getAccessRight('reportv2','V'))
                                                            <a href="{!! url('reportv2/view/'. Encryption::encode($row->report_id."/Favourites" )) !!}"
                                                               class="btn btn-xs btn-primary">
                                                                <i class="fa fa-folder-open-o"></i> Open
                                                            </a>
                                                        @endif
                                                        @if(ACL::getAccessRight('report','E'))
                                                            {!! link_to('reportv2/edit/'. Encryption::encodeId($row->report_id),'Edit',['class' => 'btn btn-default btn-xs']) !!}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <div id="list_3" class="tab-pane all_reports">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="list" class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Last Modified</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($getList['result'] as $row)
                                            <tr>
                                                <td>{!! $row->report_title !!}</td>
                                                <td>{!! $row->category_name !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($row->updated_at)) !!}</td>
                                                <td>
                                                    @if(ACL::getAccessRight('reportv2','V'))
                                                        <?php
                                                        $status = $row->status == 1 ? "Published" : "unpublished"
                                                        ?>
                                                        <a href="{!! url('reportv2/view/'. Encryption::encode($row->report_id."/".$status )) !!}"
                                                           class="btn btn-xs btn-primary">
                                                            <i class="fa fa-folder-open-o"></i> Open
                                                        </a>
                                                    @endif
                                                    @if(ACL::getAccessRight('reportv2','E'))
                                                        {!! link_to('reportv2/edit/'. Encryption::encodeId($row->report_id),'Edit',['class' => 'btn btn-default btn-xs']) !!}

                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <div id="list_4" class="tab-pane unpublished_reports">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table
                                        class="table  table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <td>Title</td>
                                            <th>Category</th>
                                            <th>Last Modified</th>
                                            <td>Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($getUnpublishedList as $row)
                                            <tr>
                                                <td>{!! $row->report_title !!}</td>
                                                <td>{!! $row->category_name !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($row->updated_at)) !!}</td>
                                                <td>
                                                    @if(Auth::user()->user_type == '1x101' || Auth::user()->user_type == '15x151')
                                                        <?php
                                                        $status = $row->status == 1 ? "Published" : "unpublished"
                                                        ?>
                                                        <a href="{!! url('reportv2/view/'.  Encryption::encode($row->report_id."/".$status )) !!}"
                                                           class="btn btn-xs btn-primary">
                                                            <i class="fa fa-folder-open-o"></i> Open
                                                        </a>
                                                        {!! link_to('reportv2/edit/'. Encryption::encodeId($row->report_id),'Edit',['class' => 'btn btn-default btn-xs']) !!}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.col-lg-12 -->

@endsection

@section('footer-script')
    @include('partials.datatable-js')

    <script>

        $(function () {
            $('#list').DataTable({
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "iDisplayLength": 25,
                "order": [[ 3, 'asc' ]]
            });
        });

        $(function () {
            $('#fav_list').DataTable({
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "iDisplayLength": 25
            });
        });

    </script>
@endsection
