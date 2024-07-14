<div id="tab_13" class="tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                5. Access Point Related Information
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Number of Branches</th>
                    <th class="text-center" colspan="2"> Number of Online Branches</th>
                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                </tr>
            </thead>
            @if ($master_data->mefNbfisDetailsTable5)
            <tr>
                <th class="d-none" style="min-width: 200px">{{ null }}</th>
                <input type="hidden" name="mef_nbfis_details_table_5_id" value="{{ $master_data->mefNbfisDetailsTable5->id ?? null }}">
                <td>{!! Form::number('nb_rural_5', $master_data->mefNbfisDetailsTable5->nb_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nb_urban_5', $master_data->mefNbfisDetailsTable5->nb_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_rural_5', $master_data->mefNbfisDetailsTable5->nob_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_urban_5', $master_data->mefNbfisDetailsTable5->nob_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>

            </tr>
            @endif
        </table>
    </div>
</div>
