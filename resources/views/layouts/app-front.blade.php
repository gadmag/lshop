<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<link rel="icon" href="{{elixir('/img/favicon.ico')}}" type="image/x-icon"/>--}}
    <meta name="description" content="Газета &quot;Шоьл тавысы&quot; - Республиканская общественно-политическая газета">
    <meta name="keywords" content="шоьл тавысы газета ногайцы ногай ногайлар noghay nogay nogai">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link href="{{ elixir('/css/all.css') }}" rel="stylesheet">
    <link href="{{ elixir('/css/app.css') }}" rel="stylesheet">
    <link href="{{ elixir('/css/inval.css') }}" rel="stylesheet">
</head>
<body id="app-layout">
@include('partials.header')

@include('partials.message')

<div class="main">
    <section class="content">
        <div class="container">
            {{--@yield('content')--}}
            <div class="first-block">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="redline">Новости дня</h2>
                        <a href="{{route('feed')}}">
                            <img src="{{elixir('/img/livemarks.png')}}" alt="feed-image"><span>RSS</span>
                        </a>
                        @foreach($dayNews as $news)
                            <div class="block-day-news">
                                <h3 class="title"><a
                                            href="{{route('news.show',['alias' => $news->id.'-'.$news->alias])}}">{{$news->title}}</a>
                                </h3>
                                <div class="pub-news">{{$news->user->name}} &nbsp;<span
                                            class="fa fa-calendar"></span> {{$news->published_at}}</div>
                                <div class="description">{!! str_limit(strip_tags($news->description),150)!!}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-3">
                        @include('block.rightTop')
                        @include('articles.archiveNews')
                    </div>
                </div>
            </div>

            <div class="second-block">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="redline">Все новости</h2>
                        @include('partials.blockAllNews')
                    </div>
                    <div class="col-md-3">
                        @include('block.rightBottom')
                    </div>
                </div>
            </div>
        </div>

    </section>

    @include('partials.footer')

</div>

<!-- JavaScripts -->
<script src="{{ elixir('/js/all.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>


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

    $('#tag_lists').select2({
        placeholder: 'Выберите теги',
        tags: true,
        data: [
            {id: 'one', text: 'One'},
            {id: 'two', text: 'Two'}

        ]

    });

</script>

</body>
</html>
