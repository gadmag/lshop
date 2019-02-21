@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Все продукты</li>
        </ol>
    </nav>

    <h1 class="title text-center">Все продукты</h1>
    <div class="panel-body">
        @if(Session::has('success'))
            <div class="row">
                <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
                    <div id="charge-message" class="alert alert-success">{{Session::get('success')}}</div>
                </div>
            </div>
        @endif
        {{--@include('product._filtered')--}}

        <div class="list-product">
                <product-list2 :filters="{{$filters}}"></product-list2>

        </div>
    </div>
    {{--{{$products->links()}}--}}

@endsection