<div id="tab_4" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    4. Financial Literacy Programmes (During the quarter)
                </li>
            </ul>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" colspan="5">Number of Participants</th>
                    </tr>
                    <tr>
                        <th>Dhaka</th>
                        <th>Other Regions</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                    </tr>
                <thead>
                <tr>
                    <td>{!! Form::number('number_of_flp_organize_dhaka', old('number_of_flp_organize_dhaka'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_flp_organize_other_region', old('number_of_flp_organize_other_region'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_participation_male', old('number_of_participation_male'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_participation_female', old('number_of_participation_female'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_participation_others', old('number_of_participation_others'), ['class' => 'form-control input-md']) !!}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
