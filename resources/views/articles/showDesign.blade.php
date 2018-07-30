@extends('layouts.app')

@section('content')

@section('title', $design->title)
@section('type', 'article')
@section('og_image'){{asset('storage/files/600x450/'.$design->files()->first()->filename)}}@endsection
@section('url'){{route('design.show', ['id' =>$design->id])}}@endsection
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

            <li class="breadcrumb-item"><a href="{{route('design.index')}}">Дизайнерские идеи</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$design->title}}</li>


        </ol>
    </nav>
@endif
<h1 class="title text-center">{{$design->title}}</h1>

<div class="article-body">
    <article>
        @if($design->files->first())
            @foreach($design->files->chunk(4) as $files)
                <div class="row">
                    @foreach($files as $file)
                        <div class="col-md-3">
                            <div class="thumbnail">
                            <a class="group1" href="{{asset('storage/files/'.$file->filename)}}" title="{{$design->title}}"> <img class="img-responsive"
                                                                src="{{asset('storage/files/400x300/'.$file->filename)}}"
                                                                alt="{{$design->title}}"></a>
                            </div>
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


@endsection