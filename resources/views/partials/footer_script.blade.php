<script>
    let ip_address = '<?php echo $_SERVER['REMOTE_ADDR']; ?>';
    let user_id = '{{ auth()->id() }}';
</script>

<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/popper/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/adminlte.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/sweetalert2.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common_v1.min.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var numberInputs = document.querySelectorAll('input[type="number"]');

        numberInputs.forEach(function (input) {
            input.setAttribute('step', 'any');
            input.addEventListener('input', function () {
                if (this.value < 0){
                    this.value = ''; // Clear the input if not valid
                }
            });
        });
    });

    // User session checking
    let setSession = '';

    function getSession() {
        $.get("/users/get-user-session", function (data, status) {
            if (data.responseCode === 1) {
                setSession = setTimeout(getSession, 6000);
            } else {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Your session has been closed. Please login again',
                    footer: '<a href="/login">Login</a>'
                }).then((result) => {
                    if (result.value) {
                        window.location.replace('/login')
                    }
                })
            }
        });
    }

    setSession = setTimeout(getSession, 120000);
</script>
{{--Extending custom script--}}
@yield('footer-script')
