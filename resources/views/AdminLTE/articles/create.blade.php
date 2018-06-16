@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($article = new \App\Articles, ['url' => route('store',['type' => $type]),'files' => true, 'class' => 'article']) !!}

                        @if($type == 'event')
                            @include('AdminLTE.articles._formEvent',['submitButtonText' => 'Добавить событие'])

                        @elseif($type == 'photo')
                            @include('AdminLTE.articles._formPhoto',['submitButtonText' => 'Добавить фотогалерею'])

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
            </div>
        </div>
    </div>
@endsection