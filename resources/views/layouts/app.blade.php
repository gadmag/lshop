<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')"/>
    @yield('og_tags')
    <meta name="image" content="@yield('og_image')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="{{elixir('/favicon.ico')}}" type="image/x-icon"/>
    <!-- Styles -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @stack('style')

    <!-- Scripts -->
    @stack('recaptcha_script')
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
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(68913259, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/68913259" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
