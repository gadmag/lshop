@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактировать: {{$service->title}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать: {{$service->title}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($service, ['method' => 'PATCH', 'action' => ['Admin\ServiceController@update', $service->id], 'class' => 'block']) !!}

            @include('AdminLTE.service._form',['submitButtonText' => 'Сохранить значение'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection