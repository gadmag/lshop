@extends('layouts.app')

@section('title', $design->meta_title)
@section('description', $design->meta_description)
@section('keywords', $design->meta_keywords)


@section('og_tags')
    <meta property="og:title" content="{{$design->title}}"/>
    <meta property="og:description" content="{{words(strip_tags($design->body), 30)}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    @if($design->files->first())
        <meta property="og:image" content="{{asset('storage/files/600x450/'.$design->files->first()->name)}}"/>
    @endif
@endsection

@section('content')

@push('scripts')
    <script src="{{elixir('/js/jquery.colorbox.js')}}"></script>
    <script>
        $(document).ready(function () {
            //Examples of how to assign the Colorbox event to elements
            $(".group1").colorbox({rel: 'group1', maxWidth: '95%', maxHeight: '95%'});
        });

    </script>

@endpush
@push('style')
    <link href="{{elixir('/css/colorbox.css')}}" rel="stylesheet">
@endpush
<div class="container">
    @if( !Request::is('/') )
        <nav aria-label="breadcrumb" role="navigation">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>

                <li class="breadcrumb-item"><a href="{{route('design.index')}}">Дизайнерские идеи</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$design->title}}</li>


            </ol>
        </nav>
    @endif
    <h1 class="title text-center py-2">{{$design->title}}</h1>

    <div class="article-body">
        <article>
            @if($design->files->first())
                @foreach($design->files->chunk(4) as $files)
                    <div class="row">
                        @foreach($files as $file)
                            <div class="col-md-3">

                                    <a class="group1" href="{{asset('storage/files/600x450/'.$file->name)}}"
                                       title="{{$design->title}}"> <img class="img-thumbnail"
                                                                        src="{{asset('storage/files/250x250/'.$file->name)}}"
                                                                        alt="{{$design->title}}"></a>

                            </div>
                        @endforeach
                    </div>
                @endforeach

            @endif
            <div class="clearfix"></div>
            <footer>
                <div class="news-navigation">

                    <div class="col-sm-6 text-left">
                        @if($previous)
                            <a href="{{route('design.show', $previous)}}">« {{$previous->title}}</a>
                        @endif
                    </div>


                    <div class="col-sm-6 text-right">
                        @if($next)
                            <a href="{{route('design.show', $next)}}">{{$next->title}} »</a>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                </div>
            </footer>

        </article>


    </div>
</div>

@endsection