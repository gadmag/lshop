@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Корзина</li>
            </ol>
        </nav>

        @if (Session::has('cart'))
            <div class="row">
                <div class="col-12">
                    <h1 class="title text-center">Корзина</h1>
                    @if($totalPrice < $paymentConf['min_sum'])

                    @endif
                    <shopping-cart :cart="cart" :carttotal="itemCount" route="{{route('checkout')}}"
                                   :minsum="{{$paymentConf['min_sum']}}"></shopping-cart>
                    @if($totalPrice >= $paymentConf['min_sum'])

                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <span>Нет товаров в корзине</span>
                </div>
            </div>
        @endif
    </div>
@endsection