@extends('layouts.app')

@section('content')
@section('title', $catalog->name)
<nav aria-label="breadcrumb" role="navigation">
    <br>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{url('catalogs')}}">Каталог</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$catalog->name}}</li>
    </ol>
</nav>

    <h1 class="heading">{{$catalog->name}}</h1>
    <div class="body">
        {!! $catalog->description !!}
    </div>
    {{--@if($article->type == 'news')--}}
        {{--<div class="article-pub"><span><i class="fa fa-calendar"></i> <i>{{$catalog->created_at}}</i></span></div>--}}
    {{--@endif--}}
    <div class="row">
    @foreach($products as $product)
        <div class="product-item col-sm-4">
            <div class="product-wrap">
            @if($product->files)
                    <img class="img-responsive" src="{{asset('storage/files/600x450/'.$product->files()->first()->filename)}}" alt="Картинка">
            @endif
        <div class="product-title"><a href="/{{empty($product->alias->alias_url)? "product/$product->id" : $product->alias->alias_url}}">{{$product->title}}</a></div>
            </div>
        </div>
    @endforeach
    </div>

@endsection