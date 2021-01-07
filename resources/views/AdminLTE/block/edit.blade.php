@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="blocks">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('blocks.index')}}">Блоки</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактировать блок: {{$block->title}}</li>
            </ol>
        </nav>
        @section('title',"Редактировать блок: {$block->title}")
        <div class="article-body">
            {!! Form::model($block, ['method' => 'PATCH', 'action' => ['Admin\BlockController@update', $block->id], 'class' => 'block']) !!}

            @include('AdminLTE.block._form',['submitButtonText' => 'Сохранить блок'])
            {!! Form::close() !!}

        </div>
    </div>

@endsection