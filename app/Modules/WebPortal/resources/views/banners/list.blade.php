@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                Banner List
            </h3>
            <div class="card-tools">
                @if ($add_permission)
                    <a href="{{ route('banners.create') }}" type="button" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New Banner
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Last Updated</th>
                        <th>Updated By</th>
                        <th>Status</th>
                        @if($edit_permission)
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
                    url: '{{ route('banners.list') }}',
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
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                        @if($edit_permission)
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
