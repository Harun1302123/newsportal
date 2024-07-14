@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
<div class="card">
    <div class="card-header card-outline card-primary">
        <h3 class="card-title">
           Poll List
        </h3>
        <div class="card-tools">
            @if ($add_permission)
                <a href="{{ route('polls.create') }}" type="button" class="btn btn-primary ">
                    <i class="fa fa-plus"></i>
                    Create New Poll
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
                        <th>Title</th>
                        <th>Image</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Poll</th>
                        <th>Yes</th>
                        <th>No</th>
                        <th>No Comments</th>
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
                    url: '{{ route('polls.list') }}',
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
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'start_at',
                        name: 'start_at'
                    },
                    {
                        data: 'end_at',
                        name: 'end_at'
                    },
                    {
                        data: 'total_poll',
                        name: 'total_poll'
                    },
                    {
                        data: 'yes',
                        name: 'yes'
                    },
                    {
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'no_comment',
                        name: 'no_comment'
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
