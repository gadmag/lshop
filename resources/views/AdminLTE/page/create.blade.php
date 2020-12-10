@extends('AdminLTE.admin')

@section('AdminLTE.content')
    @section('title','Добавить страницу')
    <div class="article-body">
        {!! Form::model($page = new \App\Page, ['url' => route('pages.store'), 'class' => 'page']) !!}

        @include('AdminLTE.page._form',['title' => 'Форма добавления', 'submitButtonText' => 'Добавить страницу'])

        {!! Form::close() !!}

    </div>
@endsection