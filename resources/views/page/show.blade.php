@extends('layouts.app')

@section('content')

@section('title', $page->meta_title)
@section('keywords', $page->meta_keywords)
@section('description', $page->meta_description)
@section('og_tags')
    <meta property="og:title" content="{{$page->title}}"/>
    <meta property="og:description" content="{{words(strip_tags($page->body), 30 )}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{$page->firstImage}}"/>
@endsection
<div class="container">
    @if( !Request::is('/') )
        <nav aria-label="breadcrumb" role="navigation">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>


            </ol>
        </nav>
    @endif
    <h1 class="title text-center">{{$page->title}}</h1>
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

    </div>
</div>
@endsection