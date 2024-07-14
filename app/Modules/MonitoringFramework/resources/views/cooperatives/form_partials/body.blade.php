<div class="nav-tabs-custom mt-3">
    <div class="card card-info">

        <div class="card-body">

            <div class="row">
                <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                    {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                    {!! Form::select('year', years(), old('year'), [
                        'id' => 'year',
                        'class' => 'form-control required',
                    ]) !!}
                    {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                </div>
                <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                    {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                    {!! Form::select('quarter', quarters(), old('quarter'), [
                        'id' => 'quarter',
                        'class' => 'form-control required',
                    ]) !!}
                    {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                </div>
            </div>
        </div>


        <div class="card-body">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="step-app" id="step-form">
                    @include('MonitoringFramework::cooperatives.form_partials.nav')
                    <div class="step-content" style="padding-top: 40px !important;">
                        <div class="step-tab-panel" data-step="step1">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_2')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_3')
                        </div>
                        <div class="step-tab-panel" data-step="step4">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_4')
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_5')
                        </div>
                        <div class="step-tab-panel" data-step="step6">
                            @include('MonitoringFramework::cooperatives.form_partials.tab_6')
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-left">
                            <a href="{{ route($list_route) }}" class="btn btn-default"><i class="fa fa-times"></i>
                                Close
                            </a>
                            <button type="submit" value="draft" name="actionBtn" class="btn btn-info cancel">Save as Draft</button>
                        </div>
                        <div class="float-right">
                            <div class="step-footer">
                                <button data-step-action="prev" class="step-btn btn btn-success">Previous</button>
                                <button data-step-action="next" class="step-btn btn btn-success">Next</button>
                                <input type="hidden" name="actionBtn" id="submitValue" value="draft">
                                <button type="submit" data-step-action="finish"  id="submitForm" value="submit" name="actionBtn" class="step-btn btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>
