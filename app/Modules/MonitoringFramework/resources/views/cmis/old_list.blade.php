@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')

    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">

    <style>
          .select2 {
            width: 100% !important;
        }
        .card-tab>.nav-item>.nav-link{
            float: left !important;
        } 
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header card-outline card-primary">
            <h3 class="card-title">
                CMIs Data List
            </h3>
            <div class="card-tools">
                @if ($add_permission)    
                <a href="{{ route('cmis.create') }}" type="button" class="btn btn-primary ">
                    <i class="fa fa-plus"></i>
                    Create New
                </a>
                @endif
                @if (((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3))
                <a href="{{ route('cmis.summary_report') }}" type="button" class="btn btn-info ">
                    <i class="fa fa-eye"></i>
                    Summary Report
                </a>
                @endif
                <a href="{{ asset('docs/Mef/CMIs.pdf') }}" target="_blank" type="button" class="btn btn-success">
                    <i class="fa fa-file"></i>
                    Explanation
                </a>
            </div>
            <div class="card-tab mt-5">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tab_1" data-toggle="tab"> List </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#tab_2" data-toggle="tab"><strong> Search</strong></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body">
          <div class="tab-content">
            <div id="tab_1" class=" tab-pane active table-responsive">
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
            <div class="tab-pane fade" id="tab_2">
                <div class="row">
                    <div class="form-group col-3 mr-1 {{ $errors->has('year') ? 'has-error' : '' }}">
                        {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                        {!! Form::select('year', years(), old('year'), [
                            'id' => 'year',
                            'class' => 'form-control required',
                        ]) !!}
                        {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                    </div>
                    <div class="form-group col-3 mr-1 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                        {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                        {!! Form::select('quarter', quarters(), old('quarter'), [
                            'id' => 'quarter',
                            'class' => 'form-control required',
                        ]) !!}
                        {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                    </div>
                    <div class="form-group col-3 mr-1 {{$errors->has('organization_id') ? 'has-error' : ''}}">
                        {!! Form::label('organization_id','Organization Name:',['class'=>'control-label required-star','id'=>'organization_list']) !!}
                        {!! Form::select('organization_id[]', [], old('organization_id'), 
                        ['class' => 'form-control select2 organization_list', 'multiple'=>'multiple']) !!}
                        {!! $errors->first('organization_id','<span class="help-block">:message</span>') !!}                    
                    </div>
                    <div class="form-group col-2 mr-1 {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', 'Select status', ['class' => 'control-label']) !!}
                        {!! Form::select('status', [], old('status'), [
                            'id' => 'status',
                            'class' => 'form-control',
                        ]) !!}
                        {!! $errors->first('status', '<span class="text-danger">:message</span>') !!}
                    </div>
                    <div class="form-group  mr-1">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Filter</button>
                    </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('footer-script')
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
    @include('partials.datatable-js')
    <script>
        $(document).ready(function() {
           $('.organization_list').select2({
               placeholder: "Select Organization"
           });
       });
   </script>
    <script>
        $(function() {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cmis.list') }}",
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
