@extends('AdminLTE.admin')

@section('AdminLTE.content')
    @section('title', "Редактировать: {$article->title}")
    <div class="articles">
        <div class="article-body">
            @include('errors.list')
            {!! Form::model($article, ['method' => 'PATCH', 'action' => ['Admin\ArticleController@update', $article->id],'files' => true, 'class' => 'article']) !!}
            @if($article->type == 'event')
                @include('AdminLTE.articles._formEvent',['submitButtonText' => 'Сохранить событие'])

            @elseif($article->type == 'photo')
                @include('AdminLTE.articles._formPhoto',['submitButtonText' => 'Сохранить фотогалерею'])
            @elseif($article->type == 'design')
                @include('AdminLTE.articles._form_design',['submitButtonText' => 'Сохранить'])

            @elseif($article->type == 'video')
                @include('AdminLTE.articles._formVideo',['submitButtonText' => 'Сохранить видео'])

            @elseif($article->type == 'page')
                @include('AdminLTE.articles._formPage', ['submitButtonText' => 'Сохранить страницу'])
            @elseif($article->type == 'news')
                @include('AdminLTE.articles._formNews', ['submitButtonText' => 'Сохранить новость'])
            @endif
            {!! Form::close() !!}

        </div>

    </div>
@endsection