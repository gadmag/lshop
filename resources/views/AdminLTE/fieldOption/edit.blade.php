@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать: {{$fieldOption->name}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($fieldOption, ['method' => 'PATCH', 'action' => ['Admin\FieldOptionController@update', $fieldOption->id], 'class' => 'block']) !!}

                            @include('AdminLTE.fieldOption._form',['submitButtonText' => 'Сохранить значение'])
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection