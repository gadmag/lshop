@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Новости</li>
        </ol>
    </nav>

                   <h1>Новости</h1>
                    <div class="news-list">
                        {{--{{dd($articles)}}--}}

                         @foreach ($articles->chunk(2) as $chunk)
                            <div class="row">
                                @foreach($chunk as $article)
                                <article class="col-sm-6">
                                    {{--{{dd($article->files()->first()->filename)}}--}}
                                    <div class="">
                                    <div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i></span></div>
                                    <h3><a href="{{action('ArticleController', [$article->id])}}">{{$article->title}}</a></h3>
                                        <div class="author"><span>Автор {{$article->user->name}}</span></div>
                                        @if(file_exists(public_path('storage/files/media/k2/items/cache/'.$article->image_md5.'_M.jpg')))
                                            <div class="image-article">
                                                <img class="thumbnail img-responsive"
                                                     src="{{asset('storage/files/media/k2/items/cache/'.$article->image_md5.'_M.jpg')}}"
                                                     alt="Картинка">
                                            </div>
                                        @endif
                                        @if($article->files->first())
                                        <div class="image-article">
                                            <img class="thumbnail img-responsive" src="{{asset('storage/files/400x300/'.$article->files()->first()->name)}}" alt="Картинка">
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
                        @endforeach

                    </div>
                    {{$articles->links()}}

@endsection