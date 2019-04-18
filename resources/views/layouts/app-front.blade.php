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
    <link href="{{ asset('/css/bootstrap-ui.css') }}" rel="stylesheet">
    <link href="{{asset('/css/fancy.slide.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body id="app-layout">
<div class="holder">
    <div class="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div id="app">
    @include('partials.header')

    @include('partials.message')

    <div class="main main-front">
        <section class="content">
            <div class="block hidden-xs first slide-block">
                <div class="container">
                    <div class="row">
                        <div class="slider-content">
                            @include('partials.slider')
                        </div>
                    </div>
                </div>
            </div>
            <div class="block block-new-product">
                <h2 class="py-2 title text-center">Новое на сайте</h2>
                <div class="container">
                    <div class="row">
                        @include('block.new_product', $newProducts)
                    </div>
                </div>
            </div>
            <div class="last block block-special">
                <h2 class="py-2 title text-center">Акции</h2>
                <div class="container">
                    <div class="row">
                        @include('block.special_product', $specials)
                    </div>
                </div>
            </div>

            @if($designItem->first())
                <h2 class="py-2 title text-center">Дизайнерские идеи</h2>
                <div class="block block-catalog-product">
                    <div class="container">
                            @include('block.design', ['designItem' => $designItem])
                    </div>
                </div>
            @endif
        </section>
        @include('partials.footer')
    </div>
</div>
<!-- JavaScripts -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/fancy.slide.js')}}"></script>
<script src="{{asset('/js/all.js') }}"></script>
</body>
</html>
