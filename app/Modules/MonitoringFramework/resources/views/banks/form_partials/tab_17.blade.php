<div id="tab_17" class=" tab-pane ">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">11. Complaints Query (During the quarter)</li>
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
