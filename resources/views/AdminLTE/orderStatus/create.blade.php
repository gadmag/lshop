@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title','Добавить статус')
    <div class="field-options">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('orderStatus.index')}}">Статусы заказа</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить статус</li>
            </ol>
        </nav>

        <div class="article-body">
            {!! Form::model($orderStatus = new \App\OrderStatus(), ['url' => route('orderStatus.store'), 'class' => 'order-status']) !!}

            @include('AdminLTE.orderStatus._form',['submitButtonText' => 'Добавить статус'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection