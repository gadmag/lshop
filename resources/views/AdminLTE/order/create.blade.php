@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Добавить заказ")
    <div class="order">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Заказы</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить заказ</li>
            </ol>
        </nav>
        <div class="order-body">
            {!! Form::model($order, ['method' => 'POST', 'action' => route('orders.store'), 'class' => 'order']) !!}

            @include('AdminLTE.order._form',['submitButtonText' => 'Добавить заказ'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection
