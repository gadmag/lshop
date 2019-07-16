@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item active">Статусы заказа</li>
        </ol>
    </nav>
    <h1>Статусы заказа</h1>
    <a href="{{route('orderStatus.create')}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить статус
    </a>
    @include('AdminLTE.orderStatus._list')

@endsection