@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Пользователи</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать пользователя {{$user->name}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\UserController@update', $user->id]]) !!}

            @include('AdminLTE.user._form',['submitButtonText' => 'Сохранить пользователя'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection