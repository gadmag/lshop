@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
        </ol>
    </nav>
    <div class="">
        <div class="">
            <h1 class="title text-center">Оформить заказ</h1>
            {{--{{dd(config('payment.shipment_method'))}}--}}
            <checkout :total="{{$total}}" :countries="{{$countries}}" :coupons="{{$coupons}}" :payment-config="{{$payment_config}}"  route="{{route('checkoutPost')}}"></checkout>

        </div>
    </div>

@endsection