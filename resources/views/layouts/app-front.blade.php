<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<link rel="icon" href="{{elixir('/img/favicon.ico')}}" type="image/x-icon"/>--}}
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    {{--<link href="https://fonts.googleapis.com/css?family=EB+Garamond&amp;subset=cyrillic-ext" rel="stylesheet">--}}
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>--}}
<!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link href="{{ elixir('/css/all.css') }}" rel="stylesheet">
    <link href="{{ elixir('/css/app.css') }}" rel="stylesheet">
    <link href="{{elixir('/css/fancy.slide.css')}}" rel="stylesheet">
</head>
<body id="app-layout">
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
                @if($designItem)
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
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ elixir('/js/all.js') }}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/fancy.slide.js')}}"></script>
<script>

    $(document).ready(function () {

        $('.block-forms a.btn').click(function (e) {
//            alert('asd');
            e.preventDefault();
            $('.block-forms a.active').removeClass('active');
            $(this).addClass('active');
            var tab = $(this).attr('href');
            console.log(tab);
            $('.form-content').not(tab).css({'display': 'none'});
            $(tab).fadeIn(400);
        });
    });

    $('div.alert').not('alert-important').delay(3000).slideUp(300);


</script>
</body>
</html>
