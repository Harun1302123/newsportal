
<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <label class="required-star"> Reason : </label>
                <textarea id="reject_reason" class="form-control" required></textarea>
                <input type="hidden" id="action" value=""/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" onclick="rejectData()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
