@extends('layouts.app')
@section('title', $article->meta_title)
@section('description', $article->meta_description)
@section('keywords', $article->meta_keywords)


@section('og_tags')
    <meta property="og:title" content="{{$article->title}}"/>
    <meta property="og:description" content="{{words(strip_tags($article->body), 30)}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    @if($article->files->first())
        <meta property="og:image" content="{{asset('storage/files/600x450/'.$article->files->first()->name)}}"/>
    @endif
@endsection

@section('content')
    @push('scripts')
        <script src="{{elixir('/js/jquery.colorbox.js')}}"></script>
        <script>
            $(document).ready(function () {
                //Examples of how to assign the Colorbox event to elements
                $(".group1").colorbox({rel: 'group1'});
            });
        </script>

    @endpush
    @push('style')
        <link href="{{elixir('/css/colorbox.css')}}" rel="stylesheet">
    @endpush
    @if( !Request::is('/') )
        <nav aria-label="breadcrumb" role="navigation">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                @if($article->type == 'news')
                    <li class="breadcrumb-item"><a href="{{route('news')}}">Новости</a></li> @endif
                <li class="breadcrumb-item active" aria-current="page">{{$article->title}}</li>


            </ol>
        </nav>
    @endif
    <h1 class="redline">{{$article->title}}</h1>
    @if($article->type == 'news')
        <p class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$article->published_at}}</i></span></p>
    @endif
    <div class="article-body">
        <article>
            @if(file_exists(public_path('storage/files/media/k2/items/cache/'.$article->image_md5.'_M.jpg')))
                <div class="text-center">
                    <img class="thumbnail img-responsive"
                         src="{{asset('storage/files/media/k2/items/cache/'.$article->image_md5.'_M.jpg')}}"
                         alt="Картинка">
                </div>
            @endif
            @if($article->files->first())
                <div class="text-center">

                    <a class="group1" href="{{asset('storage/files/'.$article->files->first()->name)}}"
                       title="{{$article->title}}">
                        <img class="thumbnail img-responsive"
                             src="{{asset('storage/files/400x300/'.$article->files->first()->name)}}"
                             alt="{{$article->title}}">
                    </a>
                </div>
            @endif
            @if($article->description)
                <div class="intro-text">
                    {!! $article->description !!}
                </div>

            @endif
            <div class="full-text">
                {!! $article->body !!}
            </div>

            <div class="clearfix"></div>
            <footer>
                @if($article->type == 'news')
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></div>
                @endif
                <div class="news-navigation">
                    @if($previous)
                        <div class="col-sm-6 text-left"><a
                                    href="{{route('news.show', $previous)}}">« {{$previous->title}}</a></div>
                    @endif
                    @if($next)
                        <div class="col-sm-6 text-right"><a href="{{route('news.show', $next)}}">{{$next->title}} »</a>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </div>

                <div class="author-block">
                    <h3 class="redline">Автор: {{$article->user->name}}</h3>
                    <div class="hidden-xs row">
                        <div class="col-sm-8">
                            <b>Эл. почта</b> <span>{{$article->user->email}}</span>
                        </div>
                        {{--                                        {!! dd($article->user->articles()->published()) !!}--}}
                        <div class="col-sm-4">
                            <div class="user-article-block">
                                <h4>Последние от {{$article->user->name}}</h4>
                                <ul class="list-unstyled">
                                    @foreach($userArticles as $userArticle)
                                        <li>
                                            <a href="{{route('news.show', $userArticle->id)}}">{{$userArticle->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </article>

        {{--<ul class="list-inline">--}}
        {{--<li>Tags:</li>--}}
        {{--@foreach($article->tags as $tags)--}}
        {{--<li><a href="{{action('TagsController@show',[$tags->name])}}">{{$tags->name}}</a></li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}

    </div>
@endsection