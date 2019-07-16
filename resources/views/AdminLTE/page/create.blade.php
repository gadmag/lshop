@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">

        <h1 class="heading">Форма создания</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($page = new \App\Page, ['url' => route('pages.store'), 'class' => 'page']) !!}

            @include('AdminLTE.page._form',['submitButtonText' => 'Добавить страницу'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection