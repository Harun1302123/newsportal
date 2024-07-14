@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
<div class="card">
    <div class="card-header card-outline card-primary">
        <h3 class="card-title">
           {{ $card_title ?? null }}
        </h3>
        <div class="card-tools">
            {!! $create_btn !!}
            {!! $summary_btn !!}
        </div>
    </div>

    <div class="card-body">
        <form id="mefDataFilterForm">
            <div class="row">
                <div class="form-group col-2 mr-1">
                    {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                    {!! Form::select('year', years(), old('year'), [
                        'id' => 'year',
                        'placeholder' => 'Select Year',
                        'class' => 'form-control required',
                    ]) !!}
                </div>
                <div class="form-group col-2 mr-1">
                    {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                    {!! Form::select('quarter', quarters(), old('quarter'), [
                        'id' => 'quarter',
                        'placeholder' => 'Select Quarter',
                        'class' => 'form-control required',
                    ]) !!}
                </div>
                <div class="form-group col-3 mr-1">
                    {!! Form::label('organization_id','Organization Name:',['class'=>'control-label required-star']) !!}
                    {!! Form::select('organization_id', organigations($orgTypeId), old('organization_id'), [
                        'id' => 'organization_id',
                        'placeholder' => 'Select Organigation',
                        'class' => 'form-control',
                        'style' => 'width: 100%',
                    ]) !!}
                </div>
                <div class="form-group col-2 mr-1">
                    {!! Form::label('status', 'Select status', ['class' => 'control-label required-star']) !!}
                    {!! Form::select('status', mefProcessStatus(), old('status'), [
                        'id' => 'status',
                        'placeholder' => 'Select Status',
                        'class' => 'form-control',
                    ]) !!}
                </div>
                <div class="form-group mr-1">
                    <label for="">&nbsp;</label>
                    <button type="button" class="mefDataFilter btn btn-primary form-control">Filter</button>
                </div>
                <div class="form-group  mr-1">
                    <label for="">&nbsp;</label>
                    <button type="button" onclick="this.form.reset();" class="btn btn-warning mefFilterResetBtn form-control">Reset</button>
                </div>
            </div>
        </form>

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
            let action_route = "{{ route($list_route) }}";
            let table = $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: action_route,
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                        d.year = document.getElementById("year").value;
                        d.quarter = document.getElementById("quarter").value;
                        d.status = document.getElementById("status").value;
                        d.organization_id = document.getElementById("organization_id").value;
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

            $('.mefDataFilter').click(function(){
                table.ajax.reload();
            });

            $('.mefFilterResetBtn').click(function(){
                table.ajax.reload();
            });
        });
    </script>
@endsection
