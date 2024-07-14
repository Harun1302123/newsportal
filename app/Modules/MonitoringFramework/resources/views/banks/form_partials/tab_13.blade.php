<div id="tab_13" class=" tab-pane ">
    <div class="table-responsive">
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center font-weight-bold">
                7. Access Point Related Information
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" colspan="2">Number of Branches</th>
                <th class="text-center" colspan="2"> Number of Online Branches</th>
                <th class="text-center" colspan="2">Number of Sub Branches</th>
                <th class="text-center" colspan="2">Number of ATM</th>
                <th class="text-center" colspan="2"> Number of CDM</th>
                <th class="text-center" colspan="2">Number of CRM</th>
                <th class="text-center" colspan="2">Number of POS</th>
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
                <th>Rural</th>
                <th>Urban</th>
            </tr>
        </thead>
            <tr>
                <th class="d-none" style="min-width: 200px">{{ $item->name ?? null }}</th>
                <td>{!! Form::number('nb_rural_7', old('nb_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nb_urban_7', old('nb_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_rural_7', old('nob_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nob_urban_7', old('nob_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nsb_rural_7', old('nsb_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('nsb_urban_7', old('nsb_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('na_rural_7', old('na_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('na_urban_7', old('na_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ncdm_rural_7', old('ncdm_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ncdm_urban_7', old('ncdm_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ncrm_rural_7', old('ncrm_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('ncrm_urban_7', old('ncrm_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('npos_rural_7', old('npos_rural_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
                <td>{!! Form::number('npos_urban_7', old('npos_urban_7'), ['class' => 'form-control input-md custom-input']) !!}</td>
            </tr>
        </table>
    </div>
</div>
