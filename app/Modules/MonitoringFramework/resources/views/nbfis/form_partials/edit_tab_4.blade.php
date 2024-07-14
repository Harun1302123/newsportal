<div id="tab_4" class=" tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">2.1 Number of Borrower</li>
        </ul>

        <table class="table table-bordered">
            <thead>
                <th colspan="15" class="text-center">Enterprise</th>
                <tr>
                    <th class="text-center" colspan="2">Large Loan</th>
                    <th class="text-center" colspan="2">Cottage</th>
                    <th class="text-center" colspan="2">Micro</th>
                    <th class="text-center" colspan="2">Small</th>
                    <th class="text-center" colspan="2">Medium</th>
                    <th class="text-center" colspan="2">Others</th>
                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>

                </tr>
            </thead>
            <tr>
                <input type="hidden" name="mef_nbfis_details_table_2_1_1_id" value="{{ $master_data->mefNbfisDetailsTable2_1_1->id ?? null }}">
                <td>{!! Form::number('large_loan_rural_2_1_1',$master_data->mefNbfisDetailsTable2_1_1->large_loan_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('large_loan_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->large_loan_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('cottage_rural_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->cottage_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('cottage_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->cottage_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('micro_rural_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->micro_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('micro_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->micro_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('small_rural_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->small_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('small_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->small_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('medium_rural_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->medium_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('medium_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->medium_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('other_rural_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->other_rural??null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('other_urban_2_1_1', $master_data->mefNbfisDetailsTable2_1_1->other_urban??null, ['class' => 'form-control input-md custom-input']) !!}</td>
            </tr>
        </table>
    </div>

    <div class="table-responsive pt-4">
        <table class="table table-bordered">
            <thead>
                <th colspan="8" class="text-center">Individual</th>
                <tr>
                    <th rowspan="2" style="min-width: 110px;">Age group</th>
                    <th class="text-center" colspan="2">Male</th>
                    <th class="text-center" colspan="2">Female</th>
                    <th class="text-center" colspan="2">Others</th>
                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                </tr>
            </thead>
            @if ($master_data->mefNbfisDetailsTable2_1_2->count())
                @foreach($master_data->mefNbfisDetailsTable2_1_2 as $key => $item)
                    <tr>
                        <th>{{ $item->mefNbfisLabel->name ?? null }}</th>
                        <input type="hidden" name="mef_nbfis_label_id_2_1_2[]" value="{{ $item->mefNbfisLabel->id ?? null }}">
                        <input type="hidden" name="mef_nbfis_details_table_2_1_2_id[]" value="{{ $item->id ?? null }}">
                        <td>{!! Form::number('male_rural_2_1_2[]', $item->male_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('male_urban_2_1_2[]', $item->male_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_rural_2_1_2[]',$item->female_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('female_urban_2_1_2[]', $item->female_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_rural_2_1_2[]', $item->others_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('others_urban_2_1_2[]', $item->others_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

    <br>
    @include('MonitoringFramework::nbfis.form_partials.edit_tab_5')

</div>
