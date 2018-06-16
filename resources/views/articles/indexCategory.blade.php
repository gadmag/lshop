@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$catalog->name}}</li>
        </ol>
    </nav>
    <div class="article-category-list">
    <h1>{{$catalog->name}}</h1>

    @foreach ($articles as $article)

        <article class="">
            {{--{{dd($article->files()->first()->filename)}}--}}
            <div class="">

                <h2 class="redline"><a href="{{action('ArticleController', [$article->id])}}">{{$article->title}}</a></h2>
                <div class="article-pub">
                    <span>Автор {{$article->user->name}}</span> |
                    <span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i></span> |
                    @if($article->catalogs->first())
                        Опубликовано {{$article->catalogs()->first()->name}}
                    @endif
                </div>
                @if($article->files->first())
                    <div class="image-article">
                        <img class="thumbnail img-responsive"
                             src="{{asset('storage/files/400x300/'.$article->files()->first()->filename)}}"
                             alt="Картинка">
                    </div>
                @endif
                @if(!empty($article->description))
                    <div class="article-description">{!! $article->description  !!}</div>
                @else
                    <div class="article-description">{!! str_limit(strip_tags($article->body), 300)  !!}</div>
                @endif


                <div class="clearfix"></div>

                <div class="article-link"><a class="readmore"
                                             href="{{action('ArticleController', [$article->id])}}">Подробнее</a>
                </div>

            </div>
        </article>


        @endforeach

        </div>
        {{$articles->links()}}
        </div>
@endsection