<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x:hidden;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href=http://zeyad.rf.gd/static/favicon.ico>
    <!-- CSRF Token -->
    <meta name="csrf-token" content={{ csrf_token() }}>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/activeNavbar.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Thambi" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    @if(Route::getFacadeRoot()->current()->uri() == '/')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    @elseif(Route::getFacadeRoot()->current()->uri() == 'upload/{type}')
        <link href="{{ asset('css/upload.css') }}" rel="stylesheet">
    @elseif( strpos(Route::getFacadeRoot()->current()->uri(), 'files') !== false)
        <link href="{{ asset('css/files.css') }}" rel="stylesheet">
    @endif
</head>
<body>
<div id="app">
        @include('inc.navbar')
        <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
            @include('inc.msgs')
            @yield('content')
            <div class="row" style="margin-top:1.5rem;">
                <div class="col-md-12 col-12 col-sm-12">
                    <div class="footer">
                        <h2 id="footerText">©<span id="date"></span> <a href="{{ route('login') }}"><span style="font-weight:700;color:white;">IS413 Team</span></a>. All Rights Reserved</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
