<div class="nav-tabs-custom mt-3">
    <div class="card card-info">

        <div class="card-body">
            <div class="row">
                <div class="form-group col-2 mr-2 {{ $errors->has('year') ? 'has-error' : '' }}">
                    {!! Form::label('year', 'Select Year', ['class' => 'required-star']) !!}
                    {!! Form::select('year', years(), $data->year??null, [
                        'id' => 'year',
                        'class' => 'form-control required',
                    ]) !!}
                    {!! $errors->first('year', '<span class="text-danger">:message</span>') !!}
                </div>
                <div class="form-group col-2 mr-2 {{ $errors->has('quarter') ? 'has-error' : '' }}">
                    {!! Form::label('quarter', 'Select Quarter', ['class' => 'required-star']) !!}
                    {!! Form::select('quarter', quarters(), $data->mef_quarter_id??null, [
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
                            @include('MonitoringFramework::insurance.form_partials.edit_tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::insurance.form_partials.edit_tab_2')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            <div id="tab_3" class=" tab-pane ">
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

                                            @if($master_data->mefInsuranceDetailsTable3->count())
                                                <tr>
                                                    <input type="hidden" name="mef_insurance_details_table_3_id" value="{{ $master_data->mefInsuranceDetailsTable3->id??null }}">
                                                    <td>{!! Form::number('nphuibs_male',  $master_data->mefInsuranceDetailsTable3->nphuibs_male ?? null , ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphuibs_female',$master_data->mefInsuranceDetailsTable3->nphuibs_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphuibs_others', $master_data->mefInsuranceDetailsTable3->nphuibs_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_mfs_male', $master_data->mefInsuranceDetailsTable3->nphppt_mfs_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_mfs_female',$master_data->mefInsuranceDetailsTable3->nphppt_mfs_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_mfs_others', $master_data->mefInsuranceDetailsTable3->nphppt_mfs_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_bank_male', $master_data->mefInsuranceDetailsTable3->nphppt_bank_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_bank_female', $master_data->mefInsuranceDetailsTable3->nphppt_bank_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nphppt_bank_others', $master_data->mefInsuranceDetailsTable3->nphppt_bank_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step4">
                            <div id="tab_4" class=" tab-pane ">
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

                                            @if($master_data->mefInsuranceDetailsTable4->count())
                                                <tr>
                                                    <input type="hidden" name="mef_insurance_details_table_4_id" value="{{ $master_data->mefInsuranceDetailsTable4->id??null }}">
                                                    <td>{!! Form::number('number_of_branch', $master_data->mefInsuranceDetailsTable4->number_of_branch, ['class' => 'form-control input-md  custom-input']) !!}</td>
                                                    <td>{!! Form::number('online_branch', $master_data->mefInsuranceDetailsTable4->online_branch, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            <div id="tab_5" class=" tab-pane ">
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
                                            @if($master_data->mefInsuranceDetailsTable5->count())
                                                <tr>
                                                    <input type="hidden" name="mef_insurance_details_table_5_id" value="{{ $master_data->mefInsuranceDetailsTable5->id??null }}">
                                                    <td>{!! Form::number('nflpo_dhaka', $master_data->mefInsuranceDetailsTable5->number_of_flpo_dhaka, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nflpo_others', $master_data->mefInsuranceDetailsTable5->number_of_flpo_other_regions, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('np_male',$master_data->mefInsuranceDetailsTable5->number_of_participants_male, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('np_female', $master_data->mefInsuranceDetailsTable5->number_of_participants_female, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('np_others', $master_data->mefInsuranceDetailsTable5->number_of_participants_others, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step6">
                            <div id="tab_6" class=" tab-pane ">
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
                                                <input type="hidden" name="mef_insurance_details_table_8_id" value="{{ $master_data->mefInsuranceDetailsTable8->id ?? null }}">
                                                <td>{!! Form::number('complaints_received', $master_data->mefInsuranceDetailsTable8->complaints_received ?? null, ['class' => 'form-control input-md ']) !!}</td>
                                                <td>{!! Form::number('complaints_resolved', $master_data->mefInsuranceDetailsTable8->complaints_resolved ?? null, ['class' => 'form-control input-md ']) !!}</td>
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