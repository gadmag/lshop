<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta property="og:url" content="@yield('url')"/>
    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:type" content="@yield('type')"/>
    <meta property="og:image" content="@yield('og_image')"/>
    <meta name="image" content="@yield('og_image')"/>
    <meta property="og:description" content="@yield('description')"/>
    <meta name="description" content="@yield('description')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="{{elixir('/img/favicon.ico')}}" type="image/x-icon"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <!-- Styles -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @stack('style')
</head>
<body id="app-layout">
<div id="app">
    @include('partials.header')
    @include('partials.message')

    <div class="main">


        <section class="content">
            <div class="container">
                @yield('content')
            </div>
        </section><!-- content -->
        <br>
        @include('partials.footer')

    </div>
    @include('partials.preload')
</div>
<!-- JavaScripts -->

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('/js/all.js') }}"></script>
@stack('scripts')
</body>
</html>
