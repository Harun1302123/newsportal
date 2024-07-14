<script>
    $(document).ready(function() {
        // Attach a click event handler to the "Save as Draft" button
        $('button[name="actionBtn"][value="draft"]').click(function() {
            // Display a confirmation dialog
            var confirmResult = confirm("Are you sure you want to save as draft?");
            if (confirmResult) {
                $('#submitValue').val('draft');
                $('#form_id').submit();
            }
            return false;
        });

        // Attach a click event handler to the "Submit" button
        $('button[name="actionBtn"][value="submit"]').click(function() {
            // Display a confirmation dialog
            var confirmResult = confirm("Are you sure you want to submit?");
            if (confirmResult) {
                $('#submitValue').val('submit');
                $('#form_id').submit();
            }
            return false;
        });
       /* $('button[data-step-action="next"]').click(function() {
            // Display a confirmation dialog
            var confirmResult = confirm("Are you sure you want to go to the next step?");
            if (confirmResult) {
            }

        });
        $('button[data-step-action="prev"]').click(function() {
            // Display a confirmation dialog
            var confirmResult = confirm("Are you sure you want to go to the previous step?");

        });*/
        $('#step-form').steps({
            onFinish: function () {
               // $('#form_id').submit();
            }
        });


    });

</script>
