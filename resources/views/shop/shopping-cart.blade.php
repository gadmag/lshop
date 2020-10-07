@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between" role="navigation">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Корзина</li>
            </ol>
            <div class="continue_by">
                <a href="/" class="text-muted"><i class="fa fa-angle-left"></i> Продолжить покупки</a>
            </div>
        </nav>
            <div class="row">
                <div class="col-12">
                    <h1 class="title pb-4 text-center">Корзина товаров</h1>
                    <shopping-cart :fonts="{{$fonts}}" :cart="cart" route="{{route('checkout')}}"
                                   :minsum="{{$config['min_sum']}}"></shopping-cart>
                </div>
            </div>
    </div>
@endsection