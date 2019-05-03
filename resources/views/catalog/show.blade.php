@extends('layouts.app')

@section('content')
@section('title', $category->name)

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
        {!! $category->description !!}
    </div>
</div>
@endsection