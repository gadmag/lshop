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
    <link rel="icon" href="{{elixir('/img/favicon.ico')}}" type="image/x-icon"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}

    <link href="{{ elixir('/css/all.css') }}" rel="stylesheet">
    <link href="{{ elixir('/css/app.css') }}" rel="stylesheet">
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
</div>
<!-- JavaScripts -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ elixir('/js/all.js') }}"></script>
<script src="{{asset('js/app.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
@stack('scripts')


</body>
</html>
