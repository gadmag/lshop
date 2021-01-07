@extends('AdminLTE.admin')

@section('title',"Редактировать пользователя {$user->name}")
@section('AdminLTE.content')
    <div class="users">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Пользователи</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
            </ol>
        </nav>

        <div class="article-body">
            {!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\UserController@update', $user->id]]) !!}

            @include('AdminLTE.user._form',['submitButtonText' => 'Сохранить пользователя'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection