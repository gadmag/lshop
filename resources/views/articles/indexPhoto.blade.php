@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Фотогалерея</li>
        </ol>
    </nav>

    <h1>Фотогалерея</h1>
    <div class="photo-list">
        {{--{{dd($articles)}}--}}

        @foreach ($photos->chunk(4) as $chunk)
            <div class="row">
                @foreach($chunk as $photo)
                    <article class="col-sm-4">

                        <div class="photo-item-wrap">



                            @if($photo->files->first())

                                <div class="thumbnail">
                                    <a href="{{action('ArticleController', [$photo->id])}}">
                                        <img src="{{asset('storage/files/600x450/'.$photo->files()->first()->filename)}}" alt="{{$photo->title}}" style="width:100%">
                                        <div class="caption">
                                            <p>{{$photo->title}}</p>
                                        </div>
                                    </a>
                                </div>

                                {{--<div class="image-gallery">--}}
                                    {{--<a class="" href="{{action('ArticleController@showPhoto', [$photo->id])}}"><img class="img-rounded img-responsive" src="{{asset('storage/files/600x450/'.$photo->files()->first()->filename)}}" alt="{{$photo->title}}"></a>--}}
                                {{--</div>--}}
                            @endif
                                {{--<h4 class="image-title"><a href="{{action('ArticleController@showPhoto', [$photo->id])}}">{{$photo->title}}</a></h4>--}}

                        </div>
                    </article>
                @endforeach
            </div>
        @endforeach

    </div>
    {{$photos->links()}}

@endsection