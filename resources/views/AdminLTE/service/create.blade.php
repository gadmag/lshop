@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="field-options">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('services.index',['type' => $type])}}">Услуги</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавить {{$title}}</li>
            </ol>
        </nav>
        @section('title',"Добавить {$title}")

        <div class="article-body">
            {!! Form::model($service = new \App\Service(), ['url' => route('services.store'), 'class' => 'block']) !!}

            @include('AdminLTE.service._form',['submitButtonText' => 'Добавить значение'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection