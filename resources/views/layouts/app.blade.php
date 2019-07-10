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
    <link rel="icon" href="{{elixir('/favicon.ico')}}" type="image/x-icon"/>
    <!-- Styles -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @stack('style')

    <!-- Scripts -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body id="app-layout">
<div id="app">
    @include('partials.header')
    @include('partials.message')

    <div class="main">
        <section class="content">
                @yield('content')
        </section><!-- content -->
        <br>
        @include('partials.footer')

    </div>
</div>

@include('partials.modal_auth')

<!-- JavaScripts -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('/js/all.js') }}"></script>
@stack('scripts')
</body>
</html>
