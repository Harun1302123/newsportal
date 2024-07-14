<!DOCTYPE html>
<html lang="en">
<!--[if IE 8]>
<html lang="bn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="bn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="bn" class="no-js">
<!--<![endif]-->

<head>
    {{--Head utilities--}}
    @include('partials.head')
</head>

<body class="hold-transition sidebar-mini">

<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="wrapper">
    @include('partials.nav')
    @include('partials.sidebar')

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                @include('partials.messages')
                @yield('content')
            </div>
        </section>
    </div>

    @include('partials.footer')
    @include('MonitoringFramework::reject_modal')
</div>

{{--JS scripts--}}
@include('partials.footer_script')
@include('MonitoringFramework::reject_modal_js')

</body>
</html>
