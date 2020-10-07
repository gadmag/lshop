@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактировать: {{$font->title}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать: {{$font->title}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($font, ['method' => 'PATCH', 'action' => ['Admin\FontController@update', $font->id], 'class' => 'block']) !!}

            @include('AdminLTE.font._form',['submitButtonText' => 'Сохранить значение'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection