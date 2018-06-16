@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать: {{$user->title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\UserController@update', $user->id]]) !!}

                            @include('AdminLTE.user._form',['submitButtonText' => 'Сохранить пользователя'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection