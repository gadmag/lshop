@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="py-4">Профиль пользователя {{$user->name}} </h1>

        @foreach($orders as $order)
            <h2 class="mt-5 mb-3">Номер заказа: №{{$order->id}}</h2>
            <p class="lead">Дата заказа {{$order->created_at}}</p>
            <div class="row mt-3">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">


                            @include('cart.table')
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Cумма платежа</p>
                    <ul class="list-unstyled p-2 mb-4">
                        <li class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Предварительная стоимость:</strong>
                            {{number_format($order->cart['totalPrice'],2,',', ' ')}} &#8381;
                        </li>
                        @if($order->cart['shipment'])
                            <li class="d-flex justify-content-between py-3 border-bottom">
                                <strong class="text-muted">{{$order->cart['shipment']['title']}}</strong>&nbsp;
                                @if(isset($order->cart['shipmentPrice']))
                                    <span class="text-nowrap">+ {{$order->cart['shipmentPrice']}} &#8381;</span>
                                @endif
                            </li>
                        @endif
                        @foreach($order->cart['coupons'] as $coupon)
                            <li class="d-flex justify-content-between py-3 border-bottom">
                                <strong class="text-muted">Промокод: {{$coupon->name}} </strong>
                                <span class="text-nowrap">- {{number_format($coupon->discount, 2, ',', ' ')}} &#8381;</span>
                            </li>
                        @endforeach

                        <li class="d-flex justify-content-between py-3 border-bottom">
                            <strong class="text-muted">Итоговая сумма</strong>
                            <h5 class="text-nowrap">{{number_format($order->cart['totalWithCoupons'],2,',', ' ')}} &#8381;</h5>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
        @endforeach
        {{$orders->links()}}

    </div>
@endsection
