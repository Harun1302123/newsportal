@if (in_array($mef_process_status_id, [5, 11, 12]))  
<div class="card text-white bg-danger" style="margin: 15px">
    <div class="card-header">Reject Reason</div>
    <div class="card-body">
        <p class="card-text">{{ $reject_reason ?? null }}</p>
    </div>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-default shortfallHistory" data-toggle="modal" data-target="#exampleModal"> More</button>
    </div>

</div>
@endif


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reject Reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <ol>
                <div class="load_data_div"></div>
            </ol>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

@section('footer-script')
<script>
    $(document).on("click", ".shortfallHistory", function () {
        let service_id = "{{ $service_id }}";
        let master_id = "{{ $master_id }}";
        if (!service_id && !master_id) {
            let defaultReason = "<li>" + "{{ $reject_reason ?? null }}" + "</li>";
            $(".load_data_div").html(defaultReason);
            return;
        }
        let reasonList = "";

        $.ajax({
            url: "{{ route('shortfall_history') }}",
            type: "get",
            data: {
                service_id: service_id,
                master_id: master_id,
            },
            beforeSend() {
                $('html,body').css('cursor', 'wait');
                $("html").css({'background-color': 'black', 'opacity': '0.5'});
                $(".loader").show();
            },
            complete() {
                $('html,body').css('cursor', 'default');
                $("html").css({'background-color': '', 'opacity': ''});
                $(".loader").hide();
            },
            success: function success(data) {
                data.forEach(function (item) {
                    reasonList += "<li>" + item + "</li>";
                });
                $(".load_data_div").html(reasonList);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
</script>
@endsection