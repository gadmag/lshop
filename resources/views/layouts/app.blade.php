<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
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
<!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '438525570500145');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=438525570500145&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->
    <script src="//code-ya.jivosite.com/widget/Ul9vMGEaVJ" async></script>
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
