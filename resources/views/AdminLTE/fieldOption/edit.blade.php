@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Редактировать: {$fieldOption->name}")
    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактировать: {{$fieldOption->name}}</li>
            </ol>
        </nav>

        <div class="article-body">
            {!! Form::model($fieldOption, ['method' => 'PATCH', 'action' => ['Admin\FieldOptionController@update', $fieldOption->id], 'class' => 'block']) !!}

            @include('AdminLTE.fieldOption._form',['submitButtonText' => 'Сохранить значение'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection