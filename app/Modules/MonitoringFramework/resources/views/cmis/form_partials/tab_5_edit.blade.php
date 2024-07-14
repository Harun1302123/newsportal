<div id="tab_5" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">5. Complaints Query (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                </thead>
                <tr>
                    <th class="text-center">Complaints Received</th>
                    <th class="text-center">Complaints Resolved</th>
                </tr>
                </thead>
                <tr>
                    <input type="hidden" name="mef_cmis_details_table_8_id" value="{{ $data->mefCmisDetailsTable8->id ?? null }}">
                    <td>{!! Form::number('complaints_received', $data->mefCmisDetailsTable8->complaints_received ?? null, ['class' => 'form-control input-md ']) !!}</td>
                    <td>{!! Form::number('complaints_resolved', $data->mefCmisDetailsTable8->complaints_resolved ?? null, ['class' => 'form-control input-md ']) !!}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
