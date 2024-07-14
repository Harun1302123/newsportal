<div class="card-body">
    <div class="row">
        <div class="table-responsive">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center font-weight-bold">Goal Tracking</li>
            </ul>
            <table class="table table-bided">
                <thead>
                <tr class="main-heading">
                    <th style="min-width: 200px;">Goals</th>
                    <th style="min-width: 250px;">Targets</th>
                    <th>Implementation Status</th>
                    <th>New Policy/Guidelines Issued or Action Taken</th>
                    <th>Visible Operational Automation Took Place</th>
                    <th>New Inclusive Financial Product Introduced</th>
                </tr>
                </thead>
                <tbody>
                @forelse (goals() as $k => $goal)
                    @foreach ($goal->targets as $k2 => $target)
                        <input type="hidden" name="target_id[]" value="{{ $target->id ?? null }}">
                        <input type="hidden" name="goal_id[]" value="{{ $goal->id ?? null }}">
                        <tr>
                            @if ($k2 < 1)
                                <th rowspan="{{ $goal->targets->count() }}">{{ $goal->id ?? null }} {{ $goal->title_en ?? null }}</th>
                            @endif
                            <td>{{ $target->target_number_en ?? null }} {{ $target->title_en ?? null }}</td>
                            @if ($goal->id != 12)
                                <td>
                                    {!! Form::select('implementation_status[]', implementationStatus(), 'PI', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                                <td colspan="3"></td>
                            @else
                                <td></td>
                                <td>
                                    {!! Form::select('goal12_policy_status[]', goal12Status(), 'no', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::select('goal12_operational_status[]', goal12Status(), 'yes', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::select('goal12_inclusive_status[]', goal12Status(), 'no', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
