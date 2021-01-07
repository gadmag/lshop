@extends('AdminLTE.admin')

@section('title','Добавление пользователя')
@section('AdminLTE.content')
    <div class="user">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Пользователи</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавление пользователя</li>
            </ol>
        </nav>
        <h1 class="heading"></h1>

        <div class="article-body">
            {!! Form::model($user = new \App\User, ['url' => route('users.store')]) !!}
            @include('AdminLTE.user._form',['submitButtonText' => 'Добавить пользователя'])
            {!! Form::close() !!}
        </div>
    </div>

@endsection