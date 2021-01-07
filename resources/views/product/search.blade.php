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
        <h1 class="d-inline pr-3 title "><strong>По запросу «{{request('keywords')}}» найдено</strong></h1> <span class="h4 text-muted">{{$count}} товаров</span>
        <div class="search-body pt-4">
            @if(count($products) > 0)
                <product-list :products="{{json_encode($products->items())}}"></product-list>
                {{$products->links()}}
            @endif
        </div>
    </div>

@endsection