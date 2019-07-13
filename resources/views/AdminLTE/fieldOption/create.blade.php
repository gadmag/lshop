@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="field-options">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('fieldOptions.index',['type' => $type])}}">Параметры опции</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить {{$title}}</li>
            </ol>
        </nav>

        <h1 class="heading">Добавить {{$title}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($fieldOption = new \App\FieldOption(), ['url' => route('fieldOptions.store'), 'class' => 'block']) !!}

            @include('AdminLTE.fieldOption._form',['submitButtonText' => 'Добавить значение'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection