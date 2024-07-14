@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header card-outline card-primary">
                <h5 class="card-title"><strong>{{ $card_title??null }}</strong></h5>
                <div class="float-right">
                    @if (in_array(Auth::user()->user_role_id, [2, 3])) 
                        <div id="excel_btn"></div>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                        {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                        {!! Form::select('year', years(), $year, [
                            'id' => 'year',
                            'onchange' => 'loadSummaryData()',
                            'class' => 'form-control required',
                        ]) !!}
                        {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                    </div>
                    <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                        {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                        {!! Form::select('quarter', quarters(), $quarter, [
                            'id' => 'quarter',
                            'onchange' => 'loadSummaryData()',
                            'class' => 'form-control required',
                        ]) !!}
                        {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div id="load_data_div"></div>


            <div class="card-footer">
                <div class="float-left">
                    <a href="{{ route($list_route) }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                    Close
                    </a>
                </div>
                <div class="float-right"></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection <!--content section-->

@section('footer-script')
<script>

    function loadSummaryData() {
        let quarter = document.getElementById("quarter").value;
        let year = document.getElementById("year").value;
        let actionUrl = "{{ $action_route }}";
        let listRoute = "{{ $list_route }}";
        if (!quarter && !year && !actionUrl && !listRoute) {
            return;
        }
        let separatedParts = listRoute.split('.');
        let source = separatedParts[0];
        let excel_btn = '<a href="/'+source+'/excel-for-summary-data?quarter='+quarter+'&year='+year+'" class="btn btn-flat btn-success btn-xs m-1"> Excel Download</a>';
        $("#excel_btn").html(excel_btn);
        $.ajax({
            url: actionUrl,
            type: "get",
            data: {
                quarter: quarter,
                year: year,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                $("#load_data_div").html(data);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    setTimeout(loadSummaryData, 0);

</script>

@endsection