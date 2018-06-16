@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Поиск</li>
        </ol>
    </nav>

    <h1>Поиск</h1>
    <div class="news-list">
        <div class="search-block-content">
            {!! Form::open(['method'=>'GET','url'=>'search','class'=>'navbar-form navbar-left','role'=>'search'])  !!}


            <div class="input-group custom-search-form">
                <input type="text" class="form-inline" name="search" placeholder="Поиск...">
                <button>Поиск</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="clearfix"></div>
        @foreach ($articles as $article)

                    <article class="">
                        {{--{{dd($article->files()->first()->filename)}}--}}
                        <div class="">

                            <h3><a href="{{action('ArticleController', [$article->id])}}">{{$article->title}}</a></h3>
                            <div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i></span></div>
                            @if(!empty($article->description))
                                <div class="article-description">{!! $article->description  !!}</div>
                            @else
                                <div class="article-description">{!! str_limit(strip_tags($article->body), 300)  !!}</div>
                            @endif


                            <div class="clearfix"></div>
                            @if($article->catalogs->first())
                                <div class="catalog">Опубликовано {{$article->catalogs()->first()->name}} </div>
                            @endif
                            <div class="article-link"><a class="readmore" href="{{action('ArticleController', [$article->id])}}">Подробнее</a></div>

                        </div>
                    </article>
            <br>
        @endforeach

    </div>
    {{$articles->links()}}

@endsection