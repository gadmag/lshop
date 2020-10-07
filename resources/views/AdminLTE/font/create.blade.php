@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="field-options">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('fonts.index')}}">Услуги</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить шрифт</li>
            </ol>
        </nav>

        <h1 class="heading">Добавить шрифт</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($font = new \App\Font(), ['url' => route('fonts.store'), 'class' => 'block']) !!}

            @include('AdminLTE.font._form',['submitButtonText' => 'Добавить значение'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection