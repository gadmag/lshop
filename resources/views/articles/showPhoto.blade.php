@extends('layouts.app')

@section('content')

@section('title', $photo->title)
@section('type', 'article')
@section('og_image'){{asset('storage/files/600x450/'.$photo->files()->first()->filename)}}@endsection
@section('url'){{action('ArticleController', [$photo->id])}}@endsection
@push('scripts')
    <script src="{{elixir('/js/jquery.colorbox.js')}}"></script>
    <script>
        $(document).ready(function(){
            //Examples of how to assign the Colorbox event to elements
            $(".group1").colorbox({rel:'group1'});
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

            <li class="breadcrumb-item"><a href="{{route('photo.index')}}">Фотогалерея</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$photo->title}}</li>


        </ol>
    </nav>
@endif
<h1 class="redline">{{$photo->title}}</h1>
@if($photo->type == 'news')
    <p class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$photo->published_at}}</i></span></p>
@endif
<div class="article-body">
    <article>
        @if($photo->files->first())
            @foreach($photo->files->chunk(4) as $files)
                <div class="row">
                    @foreach($files as $file)
                        <div class="col-md-3">
                            <div class="thumbnail">
                            <a class="group1" href="{{asset('storage/files/'.$file->filename)}}" title="{{$photo->title}}"> <img class="img-responsive"
                                                                src="{{asset('storage/files/400x300/'.$file->filename)}}"
                                                                alt="{{$photo->title}}"></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        @endif
        <div class="clearfix"></div>
        <footer>

            <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
            <script src="//yastatic.net/share2/share.js"></script>
            <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></div>

            <div class="news-navigation">

                    <div class="col-sm-6 text-left">
                        @if($previous)
                        <a href="{{route('photo.show', $previous)}}">« {{$previous->title}}</a>
                        @endif
                    </div>


                    <div class="col-sm-6 text-right">
                        @if($next)
                        <a href="{{route('photo.show', $next)}}">{{$next->title}} »</a>
                        @endif
                    </div>

                <div class="clearfix"></div>
            </div>

            <div class="author-block">
                <h3 class="redline">Автор: {{$photo->user->name}}</h3>
                <div class="hidden-xs row">
                    <div class="col-sm-8">
                        <b>Эл. почта</b> <span>{{$photo->user->email}}</span>
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