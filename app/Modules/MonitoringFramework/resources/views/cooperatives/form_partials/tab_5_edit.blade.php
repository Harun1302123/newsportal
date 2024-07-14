<div id="tab_5" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">5. Financial Literacy Programmes (During the
                    quarter)</li>
            </ul>

            <table class="table table-bordered">
                </thead>
                <tr>
                    <th class="text-center" colspan="3">Number of FL Program Organized</th>
                    <th class="text-center" colspan="4">Number of Participants</th>
                </tr>
                <tr>
                    <th>Dhaka</th>
                    <th>Other Regions</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Others</th>
                </tr>
                </thead>
                @if ($data->mefCooperativesDetailsTable5->count())
                    @php
                        $item5 = $data->mefCooperativesDetailsTable5;
                    @endphp
                    <tr>
                        <td>{!! Form::number('nflpo_dhaka', $item5->nflpo_dhaka ?? old('nflpo_dhaka'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nflpo_other_region', $item5->nflpo_other_region ?? old('nflpo_other_region'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nop_male', $item5->nop_male ?? old('nop_male'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nop_female', $item5->nop_female ?? old('nop_female'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                        <td>{!! Form::number('nop_others', $item5->nop_others ?? old('nop_others'), [
                            'class' => 'form-control input-md custom-input',
                        ]) !!}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
