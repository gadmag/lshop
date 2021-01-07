@extends('AdminLTE.admin')

@section('AdminLTE.content')
    @section('title','Форма добавления')
    <div class="articles">
        <div class="article-body">
            @include('errors.list')
            {!! Form::model($article = new \App\Article, ['url' => route('store',['type' => $type]),'files' => true, 'class' => 'article']) !!}

            @if($type == 'event')
                @include('AdminLTE.articles._formEvent',['submitButtonText' => 'Добавить событие'])

            @elseif($type == 'photo')
                @include('AdminLTE.articles._formPhoto',['submitButtonText' => 'Добавить фотогалерею'])
            @elseif($type == 'design')
                @include('AdminLTE.articles._form_design',['submitButtonText' => 'Добавить'])

            @elseif($type == 'video')
                @include('AdminLTE.articles._formVideo',['submitButtonText' => 'Добавить видео'])
            @elseif($type == 'page')
                @include('AdminLTE.articles._formPage', ['submitButtonText' => 'Добавить страницу'])
            @elseif($type == 'news')
                @include('AdminLTE.articles._formNews', ['submitButtonText' => 'Добавить новость'])
            @endif
            {!! Form::close() !!}

        </div>

    </div>
@endsection