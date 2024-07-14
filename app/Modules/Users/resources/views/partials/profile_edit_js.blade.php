@include('partials.image-upload')
<script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/intlTelInput/js/intlTelInput.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/intlTelInput/js/utils.js') }}" type="text/javascript"></script>

<script>
    $("#user_mobile").intlTelInput({
        // hiddenInput: "user_mobile",
        onlyCountries: ["bd"],
        initialCountry: "BD",
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $(".select2").select2();

        $('#submit_btn').click(function() {
            var _token = $('input[name="_token"]').val();
            $("#user_edit_form").validate({
                errorPlacement: function() {
                    return false;
                },
                submitHandler: function(form) { // <- pass 'form' argument in
                    $("#submit_btn").attr("disabled", true);
                    form.submit(); // <- use 'form' argument here.
                }
            });
        })

        // remove laravel error message start
        @if ($errors->any()) $('form input[type=text]').on('keyup', function (e) {
                if ($(this).val() && e.which != 32) {
                    $(this).siblings(".help-block").hide();
                    $(this).parent().parent().removeClass('has-error');
                }
            });

            $('form select').on('change', function (e) {
                if ($(this).val()) {
                    $(this).siblings(".help-block").hide();
                    $(this).parent().parent().removeClass('has-error');
                }
            }); @endif
    });

    $("#code").blur(function() {
        var code = $(this).val().trim();
        if (code.length > 0 && code.length < 12) {
            $('.code-error').html('');
            $('#submit_btn').attr("disabled", false);
        } else {
            $('.code-error').html('Code number should be at least 1 character to maximum  11 characters!');
            $('#submit_btn').attr("disabled", true);
        }
    });

    $(document).ready(function() {
        $('#user_type').trigger('change');
        // $('#ministry_id').trigger('change');
    })
    $('#user_type').on('change', function() {
        if ($(this).val() == 3) {
            $('#office_information_div').removeClass('hidden');
        } else {
            $('#office_information_div').addClass('hidden');
        }
    });


    function loadMinistryDivision(ministry_id, ministry_value, old_data = '') {
        // define old_data as an optional parameter
        if (typeof old_data === 'undefined') {
            old_data = 0;
        }
        if (ministry_value === '') {
            ministry_value = 0;
        }
        let _token = $('input[name="_token"]').val();


        $("#" + ministry_id).after('<span class="loading_data">Loading...</span>');
        console.log('===');

        if (ministry_value != 0) {
            $.ajax({
                type: "POST",
                url: "/users/get-ministry_division_by_ministry_id",
                data: {
                    _token: _token,
                    ministry_id: ministry_value
                },
                success: function(response) {
                    if (ministry_value == 0) {
                        var option = '<option value="">Select Ministry first</option>';
                    } else {
                        var option = '<option value="">Select Ministry Division</option>';
                    }
                    if (response.responseCode == 1) {
                        $.each(response.data, function(id, value) {
                            if (id.trim() == old_data) {
                                option += '<option value="' + id + '" selected>' + value +
                                    '</option>';
                            } else {
                                option += '<option value="' + id + '">' + value + '</option>';
                            }
                        });
                    }
                    $(".ministry_division").html(option);
                    $("#" + ministry_id).next().hide('slow');
                }
            });
        } else {
            var option = '<option value="">Select Ministry first</option>';
            $(".ministry_division").html(option);
            $("#" + ministry_id).next().hide('slow');
        }

    }


    function addTableRow(tableID, template_row_id) {
        if (tableID == 'employee_office_table') {
            $('.employee_office').select2('destroy');
        }

        let i;
        // Copy the template row (first row) of table and reset the ID and Styling
        const new_row = document.getElementById(template_row_id).cloneNode(true);
        new_row.id = "";
        new_row.style.display = "";

        // Get the total row number, and last row number of table
        let current_total_row = $('#' + tableID).find('tbody tr').length;
        let final_total_row = current_total_row + 1;


        // Generate an ID of the new Row, set the row id and append the new row into table
        let last_row_number = $('#' + tableID).find('tbody tr').last().attr('data-number');
        if (last_row_number != '' && typeof last_row_number !== "undefined") {
            last_row_number = parseInt(last_row_number) + 1;
        } else {
            last_row_number = Math.floor(Math.random() * 101);
        }

        const new_row_id = 'rowCount' + tableID + last_row_number;
        new_row.id = new_row_id;
        $("#" + tableID).append(new_row);



        // Convert the add button into remove button of the new row
        $("#" + tableID).find('#' + new_row_id).find('.addTableRows').removeClass('btn-primary').addClass('btn-danger')
            .attr('onclick', 'removeTableRow("' + tableID + '","' + new_row_id + '")');

        // Icon change of the remove button of the new row
        $("#" + tableID).find('#' + new_row_id).find('.addTableRows > .fa').removeClass('fa-plus').addClass('fa-times');
        // data-number attribute update of the new row
        $('#' + tableID).find('tbody tr').last().attr('data-number', last_row_number);


        // Get all select box elements from the new row, reset the selected value, and change the name of select box
        const all_select_box = $("#" + tableID).find('#' + new_row_id).find('select');
        all_select_box.val(''); // value reset
        all_select_box.prop('selectedIndex', 0);
        for (i = 0; i < all_select_box.length; i++) {
            const name_of_select_box = all_select_box[i].name;
            const updated_name_of_select_box = name_of_select_box.replace('[0]', '[' + last_row_number +
            ']'); //increment all array element name
            all_select_box[i].name = updated_name_of_select_box;

            const onchange_attribute = all_select_box[i].getAttribute('onchange');
            if (onchange_attribute) {
                const parts = onchange_attribute.split(', ');
                if (parts.length === 3) {
                    parts.splice(2, 1); // Remove the third parameter
                    const updated_onchange_attribute = parts.join(', ') + ')';
                    all_select_box[i].setAttribute('onchange', updated_onchange_attribute);
                }
            }
        }


        // Get all input box elements from the new row, reset the value, and change the name of input box
        const all_input_box = $("#" + tableID).find('#' + new_row_id).find('input');
        all_input_box.val(''); // value reset
        for (i = 0; i < all_input_box.length; i++) {
            const name_of_input_box = all_input_box[i].name;
            const updated_name_of_input_box = name_of_input_box.replace('[0]', '[' + last_row_number + ']');
            all_input_box[i].name = updated_name_of_input_box;
        }


        // Get all textarea box elements from the new row, reset the value, and change the name of textarea box
        const all_textarea_box = $("#" + tableID).find('#' + new_row_id).find('textarea');
        all_textarea_box.val(''); // value reset
        for (i = 0; i < all_textarea_box.length; i++) {
            const name_of_textarea = all_textarea_box[i].name;
            const updated_name_of_textarea = name_of_textarea.replace('[0]', '[' + last_row_number + ']');
            all_textarea_box[i].name = updated_name_of_textarea;
            $('#' + new_row_id).find('.readonlyClass').prop('readonly', true);
        }
        $("#" + tableID).find('.select2').select2();
        $("#" + tableID).find('#' + new_row_id).find('.remove_select option:not(:first)').remove()
    } // end of addTableRow() function
    function removeTableRow(tableID, removeNum) {
        $('#' + tableID).find('#' + removeNum).remove();
    }
    $(document).ready(function() {
        $('.ministry_division').trigger('change');
    });
</script>
