<div id="tab_3" class="tab-pane">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">3. Automation in Cooperatives</li>
            </ul>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" colspan="3">Number of Account Using Internet/Mobile App Based Service</th>
                        <th class="text-center" colspan="3">Number of Borrower Receiving Loan Through MFS</th>
                        <th class="text-center" colspan="3">Number of Borrower Paying Installment Through MFS</th>
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Others</th>
                    </tr>
                </thead>
                @if ($data->mefCooperativesDetailsTable3->count())
                    @php
                       $item3 = $data->mefCooperativesDetailsTable3;
                    @endphp
                <tr>
                    <td>{!! Form::number('maui_male', $item3->maui_male ?? old('maui_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('maui_female', $item3->maui_female ?? old('maui_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('maui_others', $item3->maui_others ?? old('maui_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                    <td>{!! Form::number('brlt_mfs_male', $item3->brlt_mfs_male ?? old('brlt_mfs_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('brlt_mfs_female', $item3->brlt_mfs_female ?? old('brlt_mfs_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('brlt_mfs_others', $item3->brlt_mfs_others ?? old('brlt_mfs_others'), ['class' => 'form-control input-md custom-input']) !!}</td>

                    <td>{!! Form::number('nbpit_mfs_male', $item3->nbpit_mfs_male ?? old('nbpit_mfs_male'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('nbpit_mfs_female',$item3->nbpit_mfs_female ?? old('nbpit_mfs_female'), ['class' => 'form-control input-md custom-input']) !!}</td>
                    <td>{!! Form::number('nbpit_mfs_others', $item3->nbpit_mfs_others ?? old('nbpit_mfs_others'), ['class' => 'form-control input-md custom-input']) !!}</td>
                </tr>
                @endif
            </table>


        </div>
    </div>
</div>
