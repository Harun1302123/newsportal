@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    <div class="card">
        <div class="card-header card-outline card-primary">
            <h3 class="card-title">
                Cooperatives Data List
            </h3>
            <div class="card-tools">
                @if ($add_permission)    
                <a href="{{ route('cooperatives.create') }}" type="button" class="btn btn-primary ">
                    <i class="fa fa-plus"></i>
                    Create New
                </a>
                @endif
                @if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3))
                <a href="{{ route('cooperatives.summary_report') }}" type="button" class="btn btn-info ">
                    <i class="fa fa-eye"></i>
                    Summary Report
                </a>
                @endif
                <a href="{{ asset('docs/Mef/Cooperatives.pdf') }}" target="_blank" type="button" class="btn btn-success">
                    <i class="fa fa-file"></i>
                    Explanation
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Organization Name</th>
                        <th>Year</th>
                        <th>Quarter</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Updated By</th>
                        @if($edit_permission || $view_permission)
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable-js')
    <script>
        $(function() {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cooperatives.list') }}",
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    },
                    error: function(xhr, error, thrown) {
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
                        data: 'organization_id',
                        name: 'organization_id'
                    },
                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'mef_quarter_id',
                        name: 'mef_quarter_id'
                    },
                    {
                        data: 'mef_process_status_id',
                        name: 'mef_process_status_id'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by'
                    },
                    @if($edit_permission || $view_permission)
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                    @endif
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection
