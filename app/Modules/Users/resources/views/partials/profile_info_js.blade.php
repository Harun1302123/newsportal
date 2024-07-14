
@include('partials.datatable-js')
@include('partials.image-upload')
<script src="{{ asset("plugins/jquery-validation/jquery.validate.min.js") }}"></script>
<script src="{{ asset("plugins/moment.min.js") }}"></script>
<script src="{{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<script src="{{ asset("plugins/intlTelInput/js/intlTelInput.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/intlTelInput/js/utils.js") }}" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="{{ asset("plugins/password-strength/password_strength.js") }}"></script>

<script>


    // Show password validation check
    $(document).ready(function () {

        $("#enable_show").on("input", function () {
            var show_pass_value = document.getElementById('enable_show').value;
            checkRegularExp(show_pass_value);
        });

    });

    function enableSavePassBtn() {
        var password_input_value = document.getElementById('user_new_password').value;
        checkRegularExp(password_input_value);
    }

    function checkRegularExp(password) {
        var submitbtn = $('#update_pass_btn');
        var user_password = $('#user_new_password');
        var enable_show = $('#enable_show');
        var regularExp = /^(?!\S*\s)(?=.*\d)(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹])(?=.*[A-Z]).{6,20}$/;

        if (regularExp.test(password) == true) {
            user_password.removeClass('is-invalid');
            user_password.addClass('is-valid');
            enable_show.removeClass('is-invalid');
            submitbtn.prop("disabled", false);
            submitbtn.removeClass("disabled");
        } else {
            enable_show.addClass('is-invalid');
            user_password.addClass('is-invalid');
            submitbtn.prop("disabled", true);
            submitbtn.addClass("disabled");
        }

    }

    $(document).ready(function ($) {
        $('#myPassword').strength_meter();
    });

    $('#myPassword').strength_meter({

        //  CSS selectors
        strengthWrapperClass: 'strength_wrapper',
        inputClass: 'strength_input',
        strengthMeterClass: 'strength_meter',
        toggleButtonClass: 'button_strength',

        // text for show / hide password links
        showPasswordText: 'Show Password',
        hidePasswordText: 'Hide Password'

    });

    function togglePasswordInfo() {
        $(".pswd_infos").toggle();
    }

    $(document).ready(function () {
        const url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        }

        $("#vreg_form").validate({
            errorPlacement: function () {
                return false;
            }
        });

        $('#password_change_form').validate({
            rules: {
                user_confirm_password: {
                    equalTo: "#user_new_password"
                }
            },
            errorPlacement: function () {
                return false;
            }
        });

        $("#update_form").validate({
            errorPlacement: function () {
                return false;
            }
        });

        let accessLogClick = 0;
        $('#accessLog').click(function () {
            accessLogClick++;
            if (accessLogClick == 1) {
                $('#accessList').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{url("users/get-access-log-data-for-self")}}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    columns: [
                        {data: 'ip_address', name: 'ip_address'},
                        {data: 'login_type', name: 'login_type'},
                        {data: 'login_dt', name: 'login_dt'},
                        {data: 'logout_dt', name: 'logout_dt'},

                    ],
                    "aaSorting": []
                });
            }
        });

        var url1 = document.location.toString();
        if (url1.match('#')) {
            if (url1.split('#')[1] == 'tab_5') {
                $('#accessLog').trigger('click')
            }
        }

        let accessLogFailedClick = 0;

        $('#accessLogFailed').click(function () {
            accessLogFailedClick++;
            if (accessLogFailedClick == 1) {
                $('#accessLogFailedList').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{url("users/get-access-log-failed")}}',
                        method: 'POST',
                        data: function (d) {
                            d.email = '{{Auth::user()->user_email}}';
                            d._token = $('input[name="_token"]').val();
                        }
                    },
                    columns: [
                        {data: 'remote_address', name: 'remote_address'},
                        {data: 'created_at', name: 'created_at'}

                    ],
                    "aaSorting": []
                });
            }
        });

        let activitiesClick = 0;
        $('#50Activities').click(function () {
            activitiesClick++;
            if (activitiesClick == 1) {
                $('#last50activities').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {

                        url: '{{url("users/get-last-50-actions")}}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    columns: [
                        {data: 'rownum', name: 'rownum'},
                        {data: 'action', name: 'action'},
                        {data: 'ip_address', name: 'ip_address'},
                        {data: 'created_at', name: 'created_at'}

                    ],
                    "aaSorting": []
                });
            }
        });

        let flag = 0;
        $('.server_date_time').on('click', function () {
            flag++;
            if (flag == 1) {
                getAppTimeDate();
                getTimeDate();
            }
        });

        function getTimeDate() {
            $.ajax({
                type: 'POST',
                url: '{{url("users/get-server-time")}}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"}
                    $('#db_date').html(data.db_date);
                    $('#db_time').html(data.db_time);
                    $('#app_date').html(d.toLocaleDateString("en-US", options));

                    getDbTimeDate(data.db_hour, data.db_min, data.db_sec);
                }
            });
        }
    });

    // analog app clock
    let d = new Date();
    let hour = d.getHours();
    let min = d.getMinutes();
    let sec = d.getSeconds();

    function getAppTimeDate() {
        //calculate angle
        let h = 30 * (parseInt(hour) + parseFloat(min / 60));
        let m = 6 * min;
        let s = 6 * sec;

        //move hands
        setAttr('h-hand', h);
        setAttr('m-hand', m);
        setAttr('s-hand', s);
        setAttr('s-tail', s + 180);

        sec++;
        if (sec == 60) {
            sec = 0;
            min++;

            if (min == 60) {
                min = 0;
                hour++;
            }
        }

        //call every second
        setTimeout(getAppTimeDate, 1000);

    };

    //analog database clock
    function getDbTimeDate(db_hour, db_min, db_sec) {

        //calculate angle
        let db_h = 30 * (parseInt(db_hour) + parseFloat(db_min / 60));
        let db_m = 6 * db_min;
        let db_s = 6 * db_sec;
        //move hands
        setAttr('db-h-hand', db_h);
        setAttr('db-m-hand', db_m);
        setAttr('db-s-hand', db_s);
        setAttr('db-s-tail', db_s + 180);

        db_sec++;
        if (db_sec == 60) {
            db_sec = 0;
            db_min++;

            if (db_min == 60) {
                db_min = 0;
                db_hour++;
            }
        }

        //call every second
        //setTimeout(getDbTimeDate(db_h, db_m, db_s), 1000);
        setTimeout(function () {
            getDbTimeDate(db_hour, db_min, db_sec);
        }, 1000);

    };

    function setAttr(id, val) {
        const v = 'rotate(' + val + ', 70, 70)';
        document.getElementById(id).setAttribute('transform', v);
    }

    function setText(id, val) {
        if (val < 10) {
            val = '0' + val;
        }
        document.getElementById(id).innerHTML = val;
    }
</script>


<script>
    $("#user_mobile").intlTelInput({
        hiddenInput: "user_mobile",
        onlyCountries: ["bd"],
        initialCountry: "BD",
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
    });
</script>
<script language="JavaScript">


    function take_snapshot() {

        Webcam.snap(function (data_uri) {

            $(".image-tag").val(data_uri);

            $("#my_camera").hide();

            $("#ts").hide();

            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            $("#results").show();
        });

    }

    $(document).ready(function () {
        $('#myPassword').strength_meter();
        $("#cameraclick").click(function () {
            Webcam.on('error', function (err) {
                toastr.options.preventDuplicates = true;
                toastr.error('Web camera not available on your device!');
                $("#reset_image_from_webcamera").trigger('click');
            });

            $("#reset_image_from_webcamera").show();

            $("#camera").show();
            $("#browseimagepp").hide();

            $("#my_camera").show();

            $("#ts").show();
            $("#results").hide();

            Webcam.set({

                width: 300,

                height: 300,

                image_format: 'jpeg',

                jpeg_quality: 90

            });


            Webcam.attach('#my_camera');
        });

        $("#reset_image_from_webcamera").click(function () {
            $("#camera").hide();
            $("#browseimagepp").show();
            $("#reset_image_from_webcamera").hide();

        });


    });

</script>