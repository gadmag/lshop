@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <h1 class="heading">Редактировать заказ: № {{$order->id}}</h1>

        <div class="order-body">
            @include('errors.list')
            {!! Form::model($order, ['method' => 'PATCH', 'action' => ['Admin\OrderController@update', $order->id], 'class' => 'order']) !!}

            @include('AdminLTE.order._form',['submitButtonText' => 'Сохранить изменеия'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection
