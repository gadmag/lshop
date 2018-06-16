@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Видеогалерея</li>
        </ol>
    </nav>

    <h1>Видео</h1>
    <div class="photo-list">
        {{--{{dd($articles)}}--}}

        @foreach ($videos as $video)
            <h3><a href="{{route('video.show',['id' => $video->id])}}">{{$video->title}}</a></h3>
            <p>{!! $video->body !!}</p>
        @endforeach

    </div>
    {{$videos->links()}}

@endsection