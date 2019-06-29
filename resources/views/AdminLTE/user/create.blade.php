@extends('AdminLTE.admin')

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
        <h1 class="heading">Добавление пользователя</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($user = new \App\User, ['url' => route('users.store')]) !!}


            @include('AdminLTE.user._form',['submitButtonText' => 'Добавить пользователя'])


            {!! Form::close() !!}

        </div>
    </div>

@endsection