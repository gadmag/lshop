@extends('layouts.app')

@section('content')

    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Поиск</span></li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <h1 class="title py-3 text-center">Поиск</h1>
        @if(count($products) > 0)
            <product-list :products="{{$products}}"></product-list>
        @else
            <p class="text-center">Нет товаров, соответствующих критериям поиска.</p>
        @endif
    </div>

@endsection