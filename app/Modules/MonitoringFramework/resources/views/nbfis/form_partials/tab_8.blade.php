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
            <tr>
                <th class="d-none" style="min-width: 200px">{{ $item->name ?? null }}</th>
                <td>{!! Form::number('nb_rural_5', old('nb_rural_5'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nb_urban_5', old('nb_urban_5'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_rural_5', old('nob_rural_5'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_urban_5', old('nob_urban_5'), ['class' => 'form-control input-md custom-input']) !!}</td>

            </tr>
        </table>
    </div>
</div>
