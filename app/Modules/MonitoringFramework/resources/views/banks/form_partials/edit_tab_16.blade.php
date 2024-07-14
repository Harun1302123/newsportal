<div id="tab_16" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                10. Financial Literacy Programmes (During the quarter)
            </li>
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
                @if ($master_data->mefBankDetailsTable10)
                    <th class="d-none" style="min-width: 200px"></th>
                    <input type="hidden" name="mef_bank_details_table_10_id" value="{{ $master_data->mefBankDetailsTable10->id ?? null }}">
                    <td>{!! Form::number('nflpo_dhaka_10',$master_data->mefBankDetailsTable10->nflpo_dhaka ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('nflpo_others_region_10',$master_data->mefBankDetailsTable10->nflpo_others_region ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('np_male_10',$master_data->mefBankDetailsTable10->np_male ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('np_female_10', $master_data->mefBankDetailsTable10->np_female ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('np_others_10', $master_data->mefBankDetailsTable10->np_others ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                @endif
            </tr>
        </table>
    </div>
</div>
