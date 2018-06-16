@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="/novosti">Новости</a></li>
            <li class="breadcrumb-item active" aria-current="page">Новости</li>
        </ol>
    </nav>
   <?php setlocale(LC_TIME, 'ru_RU.utf8'); ?>
    <h1>МАТЕРИАЛЫ ОТФИЛЬТРОВАНЫ ПО ДАТЕ: {{\Carbon\Carbon::createFromDate($year,$month,1)->formatLocalized('%B  %Y')}}</h1>
    <div class="news-list">
        {{--{{dd($articles)}}--}}

        @foreach ($dateNews as $article)

                    <article>
                        {{--{{dd($article->files()->first()->filename)}}--}}
                        <div class="">
                            <h3><a href="{{action('ArticleController', [$article->id])}}">{{$article->title}}</a></h3>
                            <div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i> <span>Автор {{$article->user->name}}</span></span></div>
                            <div class="author"></div>
                            @if($article->files->first())
                                <div class="image-article">
                                    <img class="thumbnail img-responsive" src="{{asset('storage/files/400x300/'.$article->files()->first()->filename)}}" alt="Картинка">
                                </div>
                            @endif
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
                            <br>
                            {{--<div class="tags">--}}
                            {{--<ul class="list-inline">--}}
                            {{--<li>Tags:</li>--}}
                            {{--@foreach($article->tags as $tags)--}}

                            {{--<li><a href="{{action('TagsController@show',[$tags->name])}}">{{$tags->name}}</a></li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                    </article>

        @endforeach

    </div>
    {{--{{$articles->links()}}--}}

@endsection