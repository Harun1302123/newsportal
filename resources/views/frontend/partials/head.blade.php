<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>{{ config('app.name') }}</title>

{{--meta tags--}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="nfis-development" />
<meta name="keywords" content="nfis framework">
<meta name="description"
      content="One Stop Service is an online platform integrating relevant Government agencies for providing efficient and transparent services to domestic and foreign investors" />

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

{{--Fav icon--}}
<link rel="shortcut icon" type="image/png" href="{{ asset("favicon.ico") }}"/>

{{--Fonts--}}
@if(Session::get('locale') == 'bn')
    <link rel="stylesheet"  href="{{ asset('css/fonts-bn.css') }}">
@else
    <link rel="stylesheet"  href="{{ asset('css/fonts-en.css') }}">
@endif

{{--CSS--}}
<link rel="stylesheet"  href="{{ asset('css/front.css') }}">
<link rel="stylesheet"  href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"/>
<link rel="stylesheet"  href="{{ asset('plugins/fancybox/fancybox.min.css') }}" />
<link rel="stylesheet"  href="{{ asset('css/front-style.css') }}" />
<link rel="stylesheet"  href="{{ asset('css/front-responsive.css') }}" />
<link rel="stylesheet"  href="{{ asset('css/custom-front-style.css') }}" />
<link rel="stylesheet"  href="{{ asset('plugins/accessibility/asb.css') }}" />


{{--Extending styles--}}
@yield('style')
