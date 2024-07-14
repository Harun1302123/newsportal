<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<!--[if IE 8]>
<html lang="bn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="bn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="bn" class="no-js">
<!--<![endif]-->

<head>
    {{--Head utilities--}}
    @include('frontend.partials.head')
</head>

<body>

<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="site-main">
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')
</div>

{{--JS scripts--}}
@include('frontend.partials.footer_script')

</body>
</html>
