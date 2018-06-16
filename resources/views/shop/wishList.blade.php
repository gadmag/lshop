@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Мои закладки</li>
        </ol>
    </nav>
    @if (Session::has('wishList'))
    <div class="row">
        <h1>Мои закладки</h1>
            <div class="row">
                <wish-list :product="wishList"></wish-list>
            </div>

    </div>
    @else
       <div class="row">
           <h1> Нет товаров в закладках</h1>
       </div>
    @endif

@endsection