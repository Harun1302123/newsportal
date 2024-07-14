<style>
    .analog-clock {
        width: 250px;
        height: 250px;
    }

    #clock-face {
        stroke: black;
        stroke-width: 2px;
        fill: white;
    }

    #clock-face-db {
        stroke: black;
        stroke-width: 2px;
        fill: white;
    }

    #h-hand, #m-hand, #s-hand, #s-tail, #db-h-hand, #db-m-hand, #db-s-hand, #db-s-tail {
        stroke: black;
        stroke-linecap: round;
    }

    #h-hand, #db-h-hand {
        stroke-width: 3px;
    }

    #m-hand, #db-m-hand {
        stroke-width: 2px;
    }

    #s-hand, #db-s-hand {
        stroke-width: 1px;
    }

    .time-text {
        text-align: center;
    }

    #accessList {
        height: 100px !important;
        overflow: scroll;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    .profileinfo-table {
        width: 100% !important;
    }

    .sorting {
        background-image: url(../images/sort_both_oss.png);
    }
    .nav-tabs {
    border-bottom: 0 !important;
    }
</style>
<link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}"/>
<link rel="stylesheet" href="{{ asset("plugins/intlTelInput/css/intlTelInput.min.css") }}"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<link rel="stylesheet" href="{{ asset("plugins/password-strength/password_strength.css") }}">
@include('partials.datatable-css')