<script>
    function rejectData() {
        let reject_reason = document.getElementById("reject_reason").value;
        let actionUrl = document.getElementById("action").value;
        if (!reject_reason && !actionUrl) {
            return;
        }

        $.ajax({
            url: actionUrl,
            type: "get",
            data: {
                reject_reason: reject_reason,
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
                window.location.reload();
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).on("click", ".open-rejectModal", function () {
        var action = $(this).data('action');
        $(".modal-body #action").val( action );
    });

</script>
