@extends('layouts.app')


@section('title', $category->meta_title)
@section('keywords', $category->meta_keywords)
@section('description', $category->meta_description)
@section('og_tags')
    <meta property="og:title" content="{{$category->name}}"/>
    <meta property="og:description" content="{{words(strip_tags($category->description), 30)}}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content=""/>
@endsection
@section('content')
<div class="container">

    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{route('product.index')}}">Каталог товаров</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
        </ol>
    </nav>
    <catalog-index :category="{{$category}}" :filters="{{$filters}}"></catalog-index>
    <div class="body">
    </div>
</div>
@endsection