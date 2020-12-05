@extends('layouts.app')

@section('content')
@section('title', $category->name)
@section('keywords', $category->name)
@section('description', $category->description)
@section('og_tags')
    <meta property="og:title" content="{{$category->name}}"/>
    <meta property="og:description" content="{!! $category->description !!}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content=""/>
@endsection
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