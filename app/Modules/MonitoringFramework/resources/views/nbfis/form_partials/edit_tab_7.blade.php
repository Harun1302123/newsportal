<div id="tab_12" class="tab-pane">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                4. DFS Related Information
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Number of Accounts Using Internet/App Based</th>
                    <th class="text-center" colspan="2">Credit Card Users</th>

                </tr>
                <tr>
                    <th>Rural</th>
                    <th>Urban</th>
                    <th>Rural</th>
                    <th>Urban</th>
                </tr>
            </thead>
            @if ($master_data->mefNbfisDetailsTable4)
            <tr>
                <input type="hidden" name="mef_nbfis_details_table_4_id" value="{{ $master_data->mefNbfisDetailsTable4->id ?? null }}">
                <td>{!! Form::number('nauib_rural_4', $master_data->mefNbfisDetailsTable4->nauib_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_urban_4', $master_data->mefNbfisDetailsTable4->nauib_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_rural_4', $master_data->mefNbfisDetailsTable4->ccu_rural ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_urban_4', $master_data->mefNbfisDetailsTable4->ccu_urban ?? null, ['class' => 'form-control input-md custom-input']) !!}</td>

            </tr>
            @endif
        </table>
    </div>
</div>
