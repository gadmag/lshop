@extends('AdminLTE.admin')

@section('AdminLTE.content')
    @section('title',"Редактировать {$page->title}")
    <div class="article-body">
        {!! Form::model($page, ['method' => 'PATCH', 'action' => ['Admin\PageController@update', $page->id], 'class' => 'page']) !!}

        @include('AdminLTE.page._form',['title' => 'Редактировать: '.$page->title, 'submitButtonText' => 'Сохранить страницу'])

        {!! Form::close() !!}

    </div>

@endsection