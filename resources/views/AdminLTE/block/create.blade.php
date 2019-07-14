@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="blocks">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('blocks.index')}}">Блоки</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавление блока</li>
            </ol>
        </nav>
        <h1 class="heading">Добавить блок</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($block = new \App\Block, ['url' => route('blocks.store'), 'class' => 'block']) !!}

            @include('AdminLTE.block._form',['submitButtonText' => 'Добавить блок'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection