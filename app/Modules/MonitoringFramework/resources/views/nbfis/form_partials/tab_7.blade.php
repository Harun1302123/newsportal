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
            <tr>
                <td>{!! Form::number('nauib_rural_4', old('nauib_rural_4'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nauib_urban_4', old('nauib_urban_4'), ['class' => 'form-control input-md custom-input']) !!}</td>

                <td>{!! Form::number('ccu_rural_4', old('ccu_rural_4'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ccu_urban_4', old('ccu_urban_4'), ['class' => 'form-control input-md custom-input']) !!}</td>

            </tr>
        </table>
    </div>
</div>
