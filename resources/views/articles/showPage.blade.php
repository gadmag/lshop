@extends('layouts.app')

@section('content')

@section('title', $page->title)
@section('url'){{action('ArticleController', [$page->id])}}@endsection

{{--{!! Request::url() !!}--}}
@if( !Request::is('/') )
    <nav aria-label="breadcrumb" role="navigation">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>


        </ol>
    </nav>
@endif
<h1 class="redline">{{$page->title}}</h1>
<div class="article-body">
    <article>
        @if($page->description)
            <div class="intro-text">
                {!! $page->description !!}
            </div>

        @endif
        <div class="full-text">
            {!! $page->body !!}
        </div>

        <div class="clearfix"></div>
        <footer>

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