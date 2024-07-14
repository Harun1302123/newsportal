<div class="nav-tabs-custom mt-3">
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
        </div>

        <div class="card-body">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="step-app" id="step-form">
                    @include('MonitoringFramework::mfis.form_partials.nav')
                    <div class="step-content" style="padding-top: 40px !important;">
                        <div class="step-tab-panel" data-step="step1">
                            @include('MonitoringFramework::mfis.form_partials.tab_1')
                        </div>
                        <div class="step-tab-panel" data-step="step2">
                            @include('MonitoringFramework::mfis.form_partials.tab_2')
                        </div>
                        <div class="step-tab-panel" data-step="step3">
                            <div id="tab_3" class="tab-pane">
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
                                                <td>{!! Form::number('naui_male', old('naui_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('naui_female', old('naui_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('naui_others', old('naui_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_male', old('nbrl_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_female', old('nbrl_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbrl_others', old('nbrl_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_male', old('nbpi_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_female', old('nbpi_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nbpi_others', old('nbpi_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step4">
                            <div id="tab_4" class="tab-pane">
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
                                                <td>{!! Form::number('number_of_mfis', old('number_of_mfis'), ['class' => 'form-control align-middle input-md']) !!}</td>
                                                <td>{!! Form::number('number_of_branch', old('number_of_branch'), ['class' => 'form-control input-md ']) !!}</td>
                                                <td>{!! Form::number('number_of_online_branch', old('number_of_online_branch'), ['class' => 'form-control input-md']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step5">
                            <div id="tab_5" class="tab-pane">
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
                                            @if (count($mef_mfis_details_table_5->toArray()))
                                                @foreach ($mef_mfis_details_table_5 as $item)
                                                    <tr>
                                                        <th style="min-width: 200px">{{ $item->name ?? null }}</th>
                                                        <input type="hidden" name="mef_mfis_label_id_5[]"
                                                               value="{{ $item->id ?? null }}">
                                                        <td>{!! Form::number('unclassified[]', old('unclassified[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                        <td>{!! Form::number('classified[]', old('classified[]'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step6">
                            <div id="tab_6" class="tab-pane">
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
                                            @if ($mef_mfis_details_table_6->count() < 2)
                                                <tr>
                                                    <th style="min-width: 200px">{{ $mef_mfis_details_table_6[0]->name ?? null }}</th>
                                                    <input type="hidden" name="mef_mfis_label_id_6" value="{{ $mef_mfis_details_table_6[0]->id ?? null }}">
                                                    <td>{!! Form::number('nt_male', old('nt_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nt_female', old('nt_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('nt_others', old('nt_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('at_male', old('at_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('at_female', old('at_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                    <td>{!! Form::number('at_others', old('at_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step7">
                            <div id="tab_7" class="tab-pane">
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
                                                <td>{!! Form::number('nflpo_dhaka', old('nflpo_dhaka'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('nflpo_others', old('nflpo_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_male', old('np_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_female', old('np_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                                <td>{!! Form::number('np_others', old('np_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-tab-panel" data-step="step8">
                            <div id="tab_8" class="tab-pane">
                                <div class="row">
                                    <div class="table-responsive">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-center font-weight-bold">8. Complaints Query (During the quarter)</li>
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
