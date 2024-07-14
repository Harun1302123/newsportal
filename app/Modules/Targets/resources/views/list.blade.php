@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Targets List</h3>
                    <div class="card-tools">
                        @if($add_permission)
                            <a style="margin-left: 5px" class="" href="{{ route('targets.create') }}">
                                {!! Form::button('<i class="fa fa-plus"></i><b> New target</b>', [
                                    'type' => 'button',
                                    'class' => 'btn btn-primary',
                                ]) !!}
                            </a>
                        @endif
                    </div>
                    <!-- /.card-tools -->
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
{{--                                    <th>Order</th>--}}
                                    <th>Goal</th>
                                    <th>Target Name</th>
                                    <th>Last Updated</th>
                                    <th>Updated By</th>
                                    @if($edit_permission)
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
                    url: '{{ route('targets.list')  }}',
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    // {
                    //     data: 'order',
                    //     name: 'order'
                    // },
                    {
                        data: 'goal_title',
                        name: 'goal_title'
                    },
                    {
                        data: 'target_title',
                        name: 'target_title'
                    },

                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by'
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
<!--- footer-script--->
