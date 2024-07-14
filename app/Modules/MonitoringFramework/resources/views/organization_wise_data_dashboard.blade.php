
@if ((int)Auth::user()->user_type == 1 || Auth::user()->user_role_id == 3)
<table class="table table-bordered">
    <tr class="main-heading">
        <th>Organization</th>
        <th>Approved</th>
        <th>Not Approved</th>
        <th>Not Provided</th>
        <th>Action</th>
    </tr>
    @forelse (organizationTypes() as $item)
    @php
        $data = organizationWiseDataDashboard($item->id, $item->master_table, $year, $quarter);
        $route = route($item->services->form_url . '.list'); 
        $list_btn = '<a href="' . $route . '" class="btn btn-flat btn-info btn-xs m-1"> More </a><br>';
        $approved_percentage = '<a data-toggle="modal" data-target="#organizationListModal" data-action="approved" data-organizations="'.$data['approved_list'].'" class="organizationListModalBtn btn btn-flat btn-success btn-xs m-1"> '.$data['approved_percentage'].' % </a><br>';
        $unapproved_percentage = '<a data-toggle="modal" data-target="#organizationListModal" data-action="unapproved" data-organizations="'.$data['unapproved_list'].'" class="organizationListModalBtn btn btn-flat btn-primary btn-xs m-1"> '.$data['unapproved_percentage'].' % </a><br>';
        $not_provided_percentage = '<a data-toggle="modal" data-target="#organizationListModal" data-action="not_provided" data-organizations="'.$data['not_provided_list'].'" class="organizationListModalBtn btn btn-flat btn-warning btn-xs m-1"> '.$data['not_provided_percentage'].' % </a><br>';
        
    @endphp
    <tr>
        <td>{{ $item->org_type_short_name??null }}</td>
        <td>{!! $approved_percentage ?? null !!}</td>
        <td>{!! $unapproved_percentage ?? null !!}</td>
        <td>{!! $not_provided_percentage ?? null !!}</td>
        <td>{!! $list_btn ?? null !!}</td>
    </tr>
        
    @empty
        
    @endforelse
</table>

<!-- Modal -->
<div class="modal fade" id="organizationListModal" tabindex="-1" role="dialog" aria-labelledby="organizationListModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="organizationListModalLabel">
                <div class="modal_label_div"></div>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <ol>
                <div class="load_org_data_div"></div>
            </ol>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

@endif
