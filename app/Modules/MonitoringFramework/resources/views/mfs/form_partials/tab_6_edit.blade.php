<div id="tab_6" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">6. Financial Literacy Programmes (During the quarter)</li>
            </ul>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" colspan="2">Number of FL Program Organized</th>
                        <th class="text-center" colspan="3">Number of Participants</th>
                    </tr>
                    <tr>
                        <th>Dhaka</th>
                        <th>Other Regions</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                    </tr>
                </thead>
                @if ($data->mefMfsDetailsTable6->count())
                    @php
                        $item = $data->mefMfsDetailsTable6;
                    @endphp

                    <tr>
                        <td>
                            <input type="hidden" name="mef_mfs_table6_label_id" value="{{ $item->mefMfsLabel->id??null }}">
                            {!! Form::number('nflpo_dhaka', $item->nflpo_dhaka ?? old('nflpo_dhaka'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('nflpo_other_regions', $item->nflpo_other_regions ?? old('nflpo_other_regions'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('np_male', $item->np_male ?? old('np_male'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('np_female', $item->np_female ?? old('np_female'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>
                        <td>
                            {!! Form::number('np_others', $item->np_others ?? old('np_others'), ['class' => 'form-control input-md custom-input']) !!}
                        </td>

                    </tr>

                @endif
            </table>
        </div>
    </div>
</div>