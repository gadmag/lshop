@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="article-body">
        @include('errors.list')
        {!! Form::model($page = new \App\Page, ['url' => route('pages.store'), 'class' => 'page']) !!}

        @include('AdminLTE.page._form',['title' => 'Форма добавления', 'submitButtonText' => 'Добавить страницу'])

        {!! Form::close() !!}

    </div>
@endsection