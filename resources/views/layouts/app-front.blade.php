<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<link rel="icon" href="{{elixir('/img/favicon.ico')}}" type="image/x-icon"/>--}}
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
<!-- Styles -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('/css/fancy.slide.css')}}" rel="stylesheet">
</head>
<body id="app-layout">
<div class="holder">
    <div class="preloader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<div id="app">
    @include('partials.header')

    @include('partials.message')

    <div class="main main-front">
        <section class="content">
            <div class="container">
                <div class="block hidden-xs first slide-block">
                    @include('partials.slider')
                </div>
                <h2 class="title text-center">Новое на сайте</h2>
                <div class="block block-new-product">
                    @include('block.new_product', $newProducts)
                </div>

                <h2 class="title text-center">Акции</h2>
                <div class="last block block-special">
                    @include('block.special_product', $specials)
                </div>

                @if($designItem->first())
                    <h2 class=" title text-center">Дизайнерские идеи</h2>
                    <div class="block block-catalog-product">
                        @include('block.design', ['designItem' => $designItem])
                    </div>
                @endif

            </div>

        </section>

        @include('partials.footer')

    </div>
</div>
<!-- JavaScripts -->

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('/js/all.js') }}"></script>
<script src="{{asset('js/fancy.slide.js')}}"></script>
<script>

</script>
</body>
</html>
