@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Профиль пользователя {{$user->name}}</h1>
                <hr>
                <h2>Мои покупки</h2>
                @foreach($orders as $order)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>Дата покупки {{$order->created_at}}</p>
                            @include('cart.table')
                        </div>
                        {{--<div class="panel-footer"><strong>Total price:  {{$order->cart->totalPrice}}</strong></div>--}}
                    </div>
                @endforeach
                {{$orders->links()}}
            </div>
        </div>
    </div>
@endsection
