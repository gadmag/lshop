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
        <h1 class="title text-center">Избранное</h1>
        @if (Session::has('wishList'))
            <product-list :products="{{$wishList}}"></product-list>
        @else
            <p>Нет избранных товаров.</p>
        @endif
    </div>
@endsection