@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12">
                <h1 class="title text-center">Оформить заказ</h1>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <checkout :cart="cart"
                          :countries="{{$countries}}"
                          :shipments="{{$shipments}}"
                          :payments="{{$payments}}"
                          @if($lastOrder)
                          :last-order="{{$lastOrder}}"
                          @endif
                          :config="{{$config}}"
                          route="{{route('checkoutPost')}}">
                </checkout>

            </div>
        </div>
    </div>
@endsection