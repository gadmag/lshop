@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Добавить шрифт")
    <div class="field-options">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('fonts.index')}}">Услуги</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить шрифт</li>
            </ol>
        </nav>
        <div class="article-body">
            {!! Form::model($font = new \App\Font(), ['url' => route('fonts.store'), 'class' => 'block']) !!}
            @include('AdminLTE.font._form',['submitButtonText' => 'Добавить значение'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection