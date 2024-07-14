@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-lg-12 flash-message">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Doptor API List</h3>
                    <div class="card-tools">
                        <button class="btn btn-success call-api-button" data-api-endpoint="http://127.0.0.1:5000/api/load_doptor_all_api_data"> <i class="fa fa-folder-open"></i> Load All API data</button>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                @if($add_permission || $edit_permission || $view_permission)
                                <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>
@endsection
<!--content section-->

@section('footer-script')
    @include('partials.datatable-js')
    <script>
        $(function() {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('load-doptor-api-data/get-load-doptor-api-data-list') }}',
                    method: 'get',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [{
                    data: 'param_1',
                    name: 'title'
                    },
                    {
                        data: 'active_status',
                        name: 'status'
                    },

                    @if($add_permission || $edit_permission || $view_permission)
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                    @endif
                ],
                "aaSorting": [],
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var firstRow = rows.length > 0 ? rows[0] : null;

                    // if (firstRow) {
                    //     $(firstRow).before('<tr class="odd"> <td class="dtr-control">Load all API </td> <td><span class="badge badge-success">Active</span></td> <td><button class="btn btn-success btn-xs call-api-button" data-api-endpoint="http://127.0.0.1:5000/api/load_doptor_all_api_data"> <i class="fa fa-folder-open"></i> Load data</button> </td> </tr>');
                    // }
                }
            });
        });

        $(document).on('click', '.call-api-button', function(e) {
            e.preventDefault();
            var apiEndpoint = $(this).data('api-endpoint');
            $.ajax({
                url: apiEndpoint,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        $('.flash-message').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');
                    } else {
                        $('.flash-message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error cases
                    console.log(error);
                    $('.flash-message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Data loaded faild.</div>');
                }
            });
        });
    </script>
@endsection
<!--- footer-script--->
