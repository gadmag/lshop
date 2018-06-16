@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($user = new \App\User, ['url' => route('user.store')]) !!}


                            @include('AdminLTE.user._form',['submitButtonText' => 'Добавить пользователя'])


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection