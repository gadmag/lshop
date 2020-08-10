@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Дизайнерские идеи</li>
            </ol>
        </nav>

        <h1 class="title text-center">Дизайнерские идеи</h1>
        <div class="photo-list">
            @foreach ($designs->chunk(4) as $designChunk)
                <div class="row">
                    @foreach($designChunk as $design)
                        <div class="col-sm-6 col-md-3">
                            <div class="card border-0 transform-on-hover">
                                @if($design->files()->first())
                                    <a class="" href="{{route('design.show', ['id' => $design->id])}}">
                                    <img class="card-img-top"
                                         src="{{asset('storage/files/400x300/'.$design->files()->first()->name)}}"
                                         alt="Картинка"></a>
                                @endif
                                <div class="card-body">
                                    <h6 class="text-center">
                                        <a class="" href="{{route('design.show', ['id' => $design->id])}}">
                                            {{$design->title}}</a>
                                    </h6>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
        {{$designs->links()}}
    </div>
@endsection