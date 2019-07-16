@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактировать: {{$orderStatus->name}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать: {{$orderStatus->name}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($orderStatus, ['method' => 'PATCH', 'action' => ['Admin\OrderStatusController@update', $orderStatus->id], 'class' => 'order-status']) !!}

            @include('AdminLTE.orderStatus._form',['submitButtonText' => 'Сохранить значение'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection