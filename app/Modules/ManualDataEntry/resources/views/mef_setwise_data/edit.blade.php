@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <style>
        .custom-input {
            width: 100px !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-outline card-primary">
                    <h5 class="card-title"><strong>{{ $card_title }}</strong></h5>
                </div>

                {!! Form::open([
                    'route' => 'mef_setwise_data.store',
                    'method' => 'post',
                    'id' => 'form_id',
                    'enctype' => 'multipart/form-data',
                    'files' => 'true',
                    'role' => 'form',
                ]) !!}

                <input type="hidden" name="master_id" value="{{ $id ?? null }}">


                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                            {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                            {!! Form::select('year', years(), $master_data->year ?? null, [
                                'id' => 'year',
                                'class' => 'form-control required',
                            ]) !!}
                            {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                        </div>
                        <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                            {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                            {!! Form::select('quarter', quarters(), $master_data->mef_quarter_id ?? null, [
                                'id' => 'quarter',
                                'class' => 'form-control required',
                            ]) !!}
                            {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                        </div>

                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-center">Set Name</th>
                                        <th class="text-center required-star">Maximum Score</th>
                                        <th class="text-center required-star">Benchmark / Allocated Score</th>
                                        <th class="text-center">Total Population by Census</th>
                                    </tr>

                                    @if ($master_data->MefSetManualDataDetailsRecord->count())
                                        @foreach ($master_data->MefSetManualDataDetailsRecord->sortBy('set_id')->all() as $item)
                                            @php
                                                $setWiseInfo = json_decode($item->set_info) ?? null;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->mefSet->title ?? null }}</td>
                                                <input type="hidden" name="mef_setwise_data_details_id[]" value="{{ $item->id ?? null }}">
                                                <input type="hidden" name="set_id[]" value="{{ $item->set_id ?? null }}">
                                                <td>{!! Form::number('maximum_score[]', $setWiseInfo->maximum_score ?? old('maximum_score[]'), ['class' => 'form-control input-md required']) !!}</td>
                                                <td>{!! Form::number('allocated_score[]', $setWiseInfo->allocated_score ?? old('allocated_score[]'), ['class' => 'form-control input-md required']) !!}</td>
                                                @if ($item->mefSet->name == "A")
                                                    <td>{!! Form::number('set_a_total_population', $setWiseInfo->set_a_total_population ?? old('set_a_total_population'), ['class' => 'form-control input-md']) !!}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
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
                        <button type="submit" value="draft" name="actionBtn" class="btn btn-info cancel">Save as
                            Draft</button>
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
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#form_id").validate({
                errorPlacement: function() {
                    return true;
                }
            });

            // toastr.warning('hello')

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Save as Draft button
            var saveAsDraftButton = document.querySelector('button[value="draft"]');
            if (saveAsDraftButton) {
                saveAsDraftButton.addEventListener('click', function(e) {
                    var confirmation = confirm("Are you sure you want to save as draft?");
                    if (!confirmation) {
                        e.preventDefault();
                    }
                });
            }

            // Submit button
            var submitButton = document.querySelector('button[value="submit"]');
            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    var confirmation = confirm("Are you sure you want to submit?");
                    if (!confirmation) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection
