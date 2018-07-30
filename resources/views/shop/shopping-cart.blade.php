@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Корзина</li>
        </ol>
    </nav>

    @if (Session::has('cart'))
        <div class="row">
            <div class="col-sm-10 col-md-10 col-md-offset-1 col-sm-offset-1">
                <h1>Корзина</h1>
                <shopping-cart :cart="cart" :carttotal="itemCount"></shopping-cart>
                <a href="{{route('checkout')}}" type="button" class="btn btn-success">Оформить заказ</a>
            </div>
        </div>

        {{--<div class="row">--}}
            {{--<div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">--}}
                {{--<strong>Total {{$totalPrice}}</strong>--}}
            {{--</div>--}}
        {{--</div>--}}
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">

            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>Нет товаров в корзине</h2>
            </div>
        </div>
    @endif

@endsection