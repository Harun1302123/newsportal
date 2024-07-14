<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>{{ config('app.name') }}</title>

{{--meta tags--}}
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

{{--CSS--}}
<link rel="stylesheet"  href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
<link rel="stylesheet"  href="{{ asset('css/custom-front-style.css') }}" />


{{--Extending styles--}}
@yield('header-resources')
<link rel="stylesheet"  href="{{ asset('css/adminlte.min.css') }}" />
<link rel="stylesheet"  href="{{ asset('css/custom.css') }}" />


