@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{route('blocks.index')}}">Блоки</a></li>
            <li class="breadcrumb-item active" aria-current="page">Добавление блока</li>
        </ol>
    </nav>
    <h1 class="header">Блоки</h1>
    <div class="panel-heading">
        <a href="{{route('blocks.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить блок
        </a>
    </div>
        @include('AdminLTE.block._list')

@endsection