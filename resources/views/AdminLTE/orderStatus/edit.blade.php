@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Редактировать: {$orderStatus->name}")
<div class="orderStatus">
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Редактировать: {{$orderStatus->name}}</li>
        </ol>
    </nav>
    <div class="article-body">
        {!! Form::model($orderStatus, ['method' => 'PATCH', 'action' => ['Admin\OrderStatusController@update', $orderStatus->id], 'class' => 'order-status']) !!}

        @include('AdminLTE.orderStatus._form',['submitButtonText' => 'Сохранить значение'])
        {!! Form::close() !!}

    </div>
</div>

@endsection