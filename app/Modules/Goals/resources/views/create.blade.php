@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>{{ $card_title }}</strong></h5>
                </div>

                {!! Form::open([
                'route' => 'goals.store_goal_tracking_data',
                'method' => 'post',
                'id' => 'form_id',
                'role' => 'form',
                ]) !!}

                <input type="hidden" name="master_id" value="{{ null }}">

                <div class="card card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                                {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                                {!! Form::select('year', years(), 2010, [
                                'id' => 'year',
                                'class' => 'form-control required',
                                ]) !!}
                                {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                            </div>
                            <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                                {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                                {!! Form::select('quarter', quarters(), 1, [
                                'id' => 'quarter',
                                'class' => 'form-control required',
                                ]) !!}
                                {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                            </div>
                        </div>

                        <div class="row">
                            @include('Goals::goal_tracking_form')
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route($list_route) }}" class="btn btn-sm btn-default"><i class="fa fa-times"></i>
                            Close
                        </a>
                    </div>
                    <div class="float-right">
                        {{-- <button type="submit" class="btn btn-primary">Publish</button> --}}
                        {{-- <button type="submit" value="draft" name="actionBtn" class="btn btn-info cancel">Save as Draft</button> --}}
                        <button type="submit" value="submit" name="actionBtn" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {!! form::close() !!}
            </div>
        </div>
    </div>
@endsection <!--content section-->

@section('footer-script')

@endsection
