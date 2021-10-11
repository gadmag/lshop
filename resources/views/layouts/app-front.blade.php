<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{elixir('/favicon.ico')}}" type="image/x-icon"/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
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
        fbq('init', '551144562829226');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=551144562829226&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->
    <script src="//code-ya.jivosite.com/widget/Ul9vMGEaVJ" async></script>
</head>
<body id="app-layout">
<div id="app">
    @include('partials.header')

    @include('partials.message')

    <div class="main main-front">
        <section class="content">
            <div class="block hidden-xs first slide-block">
                <div class="container">
                    @include('partials.slider')
                </div>
            </div>
    </div>
    <div class="block block-new-product">
        <h2 class="title-head mb-5 py-2 title text-center">Новое на сайте</h2>
        <div class="container">
            @include('block.new_product')
        </div>
    </div>

    @include('block.special_product')

    @if($designItem->first())
        <h2 class="title-head mb-5 py-2 title text-center">Дизайнерские идеи</h2>
        <div class="block photo-list">
            <div class="container">
                @include('block.design', ['designs' => $designItem])
            </div>
        </div>
        @endif
        </section>
        @include('partials.footer')
</div>
</div>

@include('partials.modal_auth')

<!-- JavaScripts -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/fancy.slide.js')}}"></script>
<script src="{{asset('/js/all.js') }}"></script>
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
