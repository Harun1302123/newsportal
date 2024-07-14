<div id="tab_4" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">4. Business Centres</li>
            </ul>

            <table class="table table-bordered">
                </thead>
                <tr>
                    <th class="text-center">Number of Cooperatives</th>
                    <th class="text-center">Number of Branch</th>
                    <th class="text-center">Number of Online Branch</th>

                </tr>
                </thead>
                @if ($data->mefCooperativesDetailsTable4->count())
                    @php
                        $item4 = $data->mefCooperativesDetailsTable4;
                    @endphp
                    <tr>
                        <td>{!! Form::number('noc', $item4->noc ?? old('noc'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('nob', $item4->nob ?? old('nob'), ['class' => 'form-control input-md custom-input']) !!}</td>
                        <td>{!! Form::number('noob', $item4->noob ?? old('noob'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
