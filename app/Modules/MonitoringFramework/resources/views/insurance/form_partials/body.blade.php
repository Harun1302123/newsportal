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
                    @include('MonitoringFramework::insurance.form_partials.nav')
                    <div class="step-content" style="padding-top: 40px !important;">
                        <div class="step-tab-panel" data-step="step1">
                            @include('MonitoringFramework::insurance.form_partials.tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::insurance.form_partials.tab_2')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            <div id="tab_3" class=" tab-pane">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">3. Automation in Insurance Companies</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center" colspan="3">Number of Policy Holder Using Internet Based Service</th>
                                                <th class="text-center" colspan="3">Number of Policy Holder Paying Premium Through MFS</th>
                                                <th class="text-center" colspan="3">Number of Policy Holder Paying Premium Through Bank</th>
                                            </tr>
                                            <tr>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Others</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Others</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Others</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>{!! Form::number('nphuibs_male', old('nphuibs_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphuibs_female', old('nphuibs_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphuibs_others', old('nphuibs_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_mfs_male', old('nphppt_mfs_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_mfs_female', old('nphppt_mfs_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_mfs_others', old('nphppt_mfs_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_bank_male', old('nphppt_bank_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_bank_female', old('nphppt_bank_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nphppt_bank_others', old('nphppt_bank_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step4">
                            <div id="tab_4" class=" tab-pane">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">4. Business Centres</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Number of Branch</th>
                                                <th class="text-center">Online Branch</th>

                                            </tr>
                                            </thead>

                                            <tr>
                                                <td>{!! Form::number('number_of_branch', old('number_of_branch'), ['class' => 'form-control input-md w-75']) !!}</td>
                                                <td>{!! Form::number('online_branch', old('online_branch'), ['class' => 'form-control input-md  w-75']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            <div id="tab_5" class=" tab-pane">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">5. Financial Literacy
                                                Programmes (During the quarter)</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center" colspan="2">Number of FL Program Organized</th>
                                                <th class="text-center" colspan="3">Number of Participants</th>
                                            </tr>
                                            <tr>
                                                <th>Dhaka</th>
                                                <th>Other Regions</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Others</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>{!! Form::number('nflpo_dhaka', old('nflpo_dhaka'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nflpo_others', old('nflpo_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_male', old('np_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_female', old('np_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_others', old('np_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            <div id="tab_6" class=" tab-pane">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">6. Complaints Query (During the quarter)</li>
                                        </ul>
                            
                                        <table class="table table-bordered">
                                        </thead>
                                            <tr>
                                                <th class="text-center">Complaints Received</th>
                                                <th class="text-center">Complaints Resolved</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>{!! Form::number('complaints_received', old('complaints_received'), ['class' => 'form-control input-md ']) !!}</td>
                                            <td>{!! Form::number('complaints_resolved', old('complaints_resolved'), ['class' => 'form-control input-md ']) !!}</td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
