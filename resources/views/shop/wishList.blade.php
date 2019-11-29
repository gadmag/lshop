@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Избранное</li>
            </ol>
        </nav>
        <h1 class="title text-center pb-4">Избранное</h1>
        @if (count($products) > 0)
            <product-list :products="{{$products}}"></product-list>
        @else
            <h4 class="text-center">Нет избранных товаров.</h4>
        @endif
    </div>
@endsection