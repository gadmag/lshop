@extends('layouts.app')

@section('content')

@section('title', $video->title)
@section('type', 'article')
@section('url'){{action('ArticleController', [$video->id])}}@endsection

    <link href="{{elixir('/css/colorbox.css')}}" rel="stylesheet">

@if( !Request::is('/') )
    <nav aria-label="breadcrumb" role="navigation">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>

            <li class="breadcrumb-item"><a href="{{route('video.index')}}">Видео</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$video->title}}</li>


        </ol>
    </nav>
@endif
<h1 class="redline">{{$video->title}}</h1>
<div class="article-body">
    <article>
       <p>{!! $video->body !!}</p>
        <div class="clearfix"></div>
        <footer>

            <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
            <script src="//yastatic.net/share2/share.js"></script>
            <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></div>

            <div class="news-navigation">

                <div class="col-sm-6 text-left">
                    @if($previous)
                        <a href="{{route('video.show', $previous)}}">« {{$previous->title}}</a>
                    @endif
                </div>


                <div class="col-sm-6 text-right">
                    @if($next)
                        <a href="{{route('video.show', $next)}}">{{$next->title}} »</a>
                    @endif
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="author-block">
                <h3 class="redline">Автор: {{$video->user->name}}</h3>
                <div class="hidden-xs row">
                    <div class="col-sm-8">
                        <b>Эл. почта</b> <span>{{$video->user->email}}</span>
                    </div>
                    {{--                                        {!! dd($photo->user->articles()->published()) !!}--}}
                </div>
            </div>
        </footer>

    </article>

    {{--<ul class="list-inline">--}}
    {{--<li>Tags:</li>--}}
    {{--@foreach($photo->tags as $tags)--}}
    {{--<li><a href="{{action('TagsController@show',[$tags->name])}}">{{$tags->name}}</a></li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}

</div>


@endsection