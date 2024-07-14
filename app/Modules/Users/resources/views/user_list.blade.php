@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h3 class="card-title">User List</h3>
                    <div class="card-tools">
                        @if ($add_permission)
                            <a class="btn btn-primary btn-sm" href="{{ url('/users/create') }}">
                                <i class="fa fa-plus"></i>
                                {{ trans('Users::messages.new_user') }}
                            </a>
                        @endif
                    </div>
                    <!-- /.card-tools -->
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{!! trans('Users::messages.user_name') !!}</th>
                                <th>{!! trans('Users::messages.user_email') !!}</th>
                                <th>{!! trans('Users::messages.user_type') !!}</th>
                                <th>User Role</th>
                                <th>{!! trans('Users::messages.status') !!}</th>
                                <th>{!! trans('Users::messages.member_since') !!}</th>
                                <th>{!! trans('Users::messages.action') !!}</th>
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
                    url: '{{ url('users/get-users-list') }}',
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [{
                    data: 'username',
                    name: 'username'
                },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    {
                        data: 'type_name',
                        name: 'type_name'
                    },
                    {
                        data: 'role_name',
                        name: 'role_name'
                    },
                    {
                        data: 'user_status',
                        name: 'user_status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
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
        });
    </script>
@endsection
<!--- footer-script--->
