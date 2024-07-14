<div id="tab_3" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    3. CMI Related Information
                </li>
            </ul>

            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Type of CMI</th>
                    <th class="text-center">Number of CMIs</th>
                    <th class="text-center">Number of Branch</th>
                    <th class="text-center">Number of Online Branch</th>
                </tr>
            </thead>
                @if ($data->mefCmisDetailsTable3->count())
                    @foreach ($data->mefCmisDetailsTable3->sortBy('mef_cmis_label_id')->all() as $item3)
                        <tr>
                            <th>
                                <input type="hidden" name="mef_cmis_table3_label_id[]" value="{{ $item3->mefCmisLabel->id ?? null }}">
                                <input type="hidden" name="mef_cmis_details_table_3_id[]" value="{{ $item3->id ?? null }}">
                                {{ $item3->mefCmisLabel->name }}
                            </th>
                            <td>{!! Form::number('number_of_cmis[]', $item3->number_of_cmis ?? old('number_of_cmis'), ['class' => 'form-control ']) !!}</td>
                            <td>{!! Form::number('number_of_branch[]', $item3->number_of_branch ?? old('number_of_branch'), ['class' => 'form-control input-md']) !!}</td>
                            <td>{!! Form::number('number_of_online_branch[]', $item3->number_of_online_branch ?? old('number_of_online_branch'), ['class' => 'form-control input-md']) !!}</td>
                        </tr>
                    @endforeach
                @endif

            </table>


        </div>
    </div>
</div>
