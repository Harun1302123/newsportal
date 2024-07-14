<div class="nav-tabs-custom mt-3">
    <div class="card card-info">

        <div class="card-body">
            <div class="row">
                <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                    {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                    {!! Form::select('year', years(), $master_data->year??null, [
                        'id' => 'year',
                        'class' => 'form-control required',
                    ]) !!}
                    {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                </div>
                <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                    {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                    {!! Form::select('quarter', quarters(), $master_data->mef_quarter_id??null, [
                        'id' => 'quarter',
                        'class' => 'form-control required',
                    ]) !!}
                    {!! $errors->first('quarter', '<span class="text-danger">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="step-app" id="step-form">
                    @include('MonitoringFramework::banks.form_partials.nav')
                    <div class="step-content" style="padding-top: 40px !important;">
                        <div class="step-tab-panel" data-step="step1">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_4')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_6')
                        </div>
                        <div class="step-tab-panel" data-step="step4">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_9')
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_11')
                        </div>
                        <div class="step-tab-panel" data-step="step6">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_12')
                        </div>
                        <div class="step-tab-panel" data-step="step7">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_13')
                        </div>
                        <div class="step-tab-panel" data-step="step8">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_14')
                        </div>
                        <div class="step-tab-panel" data-step="step9">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_15')
                        </div>
                        <div class="step-tab-panel" data-step="step10">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_16')
                        </div>
                        <div class="step-tab-panel" data-step="step11">
                            @include('MonitoringFramework::banks.form_partials.edit_tab_17')
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
