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
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="step-app" id="step-form">
                    @include('MonitoringFramework::mfis.form_partials.nav')
                    <div class="step-content" style="padding-top: 40px !important;">
                        <div class="step-tab-panel" data-step="step1">
                            @include('MonitoringFramework::mfis.form_partials.edit_tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::mfis.form_partials.edit_tab_2')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            <div id="tab_3" class=" tab-pane ">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">3. Automation in MFIs</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center" colspan="3">Number of Account Using Internet/Mobile App
                                                    Based Service</th>
                                                <th class="text-center" colspan="3">Number of Borrower Receiving Loan Through MFS
                                                </th>
                                                <th class="text-center" colspan="3">Number of Borrower Paying Installment Through
                                                    MFS</th>

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
                                                <input type="hidden" name="mef_mfis_details_table_3_id" value="{{ $master_data->mefMfisDetailsTable3->id??null }}">
                                                <td>{!! Form::number('naui_male', $master_data->mefMfisDetailsTable3->naui_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('naui_female', $master_data->mefMfisDetailsTable3->naui_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('naui_others', $master_data->mefMfisDetailsTable3->naui_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_male', $master_data->mefMfisDetailsTable3->naui_total??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_female', $master_data->mefMfisDetailsTable3->nbrl_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_others', $master_data->mefMfisDetailsTable3->nbrl_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_male', $master_data->mefMfisDetailsTable3->nbrl_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_female', $master_data->mefMfisDetailsTable3->nbrl_total??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_others', $master_data->mefMfisDetailsTable3->nbpi_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>
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
                                            <li class="list-group-item text-center font-weight-bold">4. MFI Related Information</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Number of MFIs</th>
                                                <th class="text-center">Number of Branch</th>
                                                <th class="text-center">Number of Online Branch</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <input type="hidden" name="mef_mfis_details_table_4_id" value="{{ $master_data->mefMfisDetailsTable4->id??null }}">
                                                <td>{!! Form::number('number_of_mfis', $master_data->mefMfisDetailsTable4->number_of_mfis??null, ['class' => 'form-control align-middle input-md ']) !!}</td>
                                                <td>{!! Form::number('number_of_branch', $master_data->mefMfisDetailsTable4->number_of_branch??null, ['class' => 'form-control input-md ']) !!}</td>
                                                <td>{!! Form::number('number_of_online_branch', $master_data->mefMfisDetailsTable4->number_of_online_branch??null, ['class' => 'form-control input-md ']) !!}</td>
                                            </tr>
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
                                            <li class="list-group-item text-center font-weight-bold">5. Non Performing Loans</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th class="text-center">Unclassified</th>
                                                <th class="text-center">classified</th>

                                            </tr>
                                            </thead>
                                            @if ($master_data->mefMfisDetailsTable5->count())
                                                @foreach ($master_data->mefMfisDetailsTable5 as $item)
                                                    <tr>
                                                        <td>{{ $item->mefMfisLabel->name??null }}</td>
                                                        <input type="hidden" name="mef_mfis_details_table_5_id[]" value="{{ $item->id ?? null }}">
                                                        <input type="hidden" name="mef_mfis_label_id_5[]" value="{{ $item->mef_mfis_label_id ?? null }}">
                                                        <td>{!! Form::number('unclassified[]', $item->unclassified??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                        <td>{!! Form::number('classified[]', $item->classified??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    </tr>
                                                @endforeach
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
                                            <li class="list-group-item text-center font-weight-bold">6. Foreign Remittance</li>
                                        </ul>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-right" colspan="9">During the quarter</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2"></th>
                                                <th class="text-center" colspan="3">Number of Transaction</th>
                                                <th class="text-center" colspan="3">Amount of Transaction</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Male</th>
                                                <th class="text-center">female</th>
                                                <th class="text-center">Others</th>
                                                <th class="text-center">Male</th>
                                                <th class="text-center">female</th>
                                                <th class="text-center">Others</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <th style="min-width: 200px">{{ $master_data->mefMfisDetailsTable6->mefMfisLabel->name??null }}</th>
                                                <input type="hidden" name="mef_mfis_details_table_6_id" value="{{ $master_data->mefMfisDetailsTable6->id??null }}">
                                                <input type="hidden" name="mef_mfis_label_id_6" value="{{ $master_data->mefMfisDetailsTable6->mef_mfis_label_id??null }}">
                                                <td>{!! Form::number('nt_male', $master_data->mefMfisDetailsTable6->nt_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nt_female', $master_data->mefMfisDetailsTable6->nt_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nt_others', $master_data->mefMfisDetailsTable6->nt_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('at_male', $master_data->mefMfisDetailsTable6->at_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('at_female', $master_data->mefMfisDetailsTable6->at_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('at_others', $master_data->mefMfisDetailsTable6->at_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step7">
                            <div id="tab_7" class=" tab-pane ">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">7. Financial Literacy
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
                                                <input type="hidden" name="mef_mfis_details_table_7_id" value="{{ $master_data->mefMfisDetailsTable7->id??null }}">
                                                <td>{!! Form::number('nflpo_dhaka', $master_data->mefMfisDetailsTable7->nflpo_dhaka??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nflpo_others', $master_data->mefMfisDetailsTable7->nflpo_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_male', $master_data->mefMfisDetailsTable7->np_male??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_female', $master_data->mefMfisDetailsTable7->np_female??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_others', $master_data->mefMfisDetailsTable7->np_others??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step8">
                            <div id="tab_8" class=" tab-pane ">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">7. Complaints Query (During the quarter)</li>
                                        </ul>
                            
                                        <table class="table table-bordered">
                                            </thead>
                                            <tr>
                                                <th class="text-center">Complaints Received</th>
                                                <th class="text-center">Complaints Resolved</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <input type="hidden" name="mef_mfis_details_table_8_id" value="{{ $master_data->mefMfisDetailsTable8->id ?? null }}">
                                                <td>{!! Form::number('complaints_received', $master_data->mefMfisDetailsTable8->complaints_received ?? null, ['class' => 'form-control input-md ']) !!}</td>
                                                <td>{!! Form::number('complaints_resolved', $master_data->mefMfisDetailsTable8->complaints_resolved ?? null, ['class' => 'form-control input-md ']) !!}</td>
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
