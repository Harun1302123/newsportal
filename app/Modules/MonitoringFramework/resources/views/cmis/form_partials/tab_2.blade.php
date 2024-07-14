<div id="tab_2" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">
                    2. Automation Related Information
                </li>
            </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" colspan="5">Number of BO Accounts Using Mobile App</th>
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Femate</th>
                        <th>Others</th>
                        <th>Institutional</th>
                    </tr>
                </thead>
                <tr>
                    <td>{!! Form::number('number_of_boauma_male', old('number_of_boauma_male'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_boauma_female', old('number_of_boauma_female'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_boauma_others', old('number_of_boauma_others'), ['class' => 'form-control input-md']) !!}</td>
                    <td>{!! Form::number('number_of_boauma_institutional', old('number_of_boauma_institutional'), ['class' => 'form-control input-md']) !!}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
