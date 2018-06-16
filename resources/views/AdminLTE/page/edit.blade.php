@extends('AdminLTE.admin')

@section('AdminLTE.content')

                <div class="">
                    <h1 class="heading">Редактировать: {{$page->title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($page, ['method' => 'PATCH', 'action' => ['Admin\PageController@update', $page->id], 'class' => 'page']) !!}

                            @include('AdminLTE.page._form',['submitButtonText' => 'Сохранить страницу'])

                        {!! Form::close() !!}

                    </div>
                </div>
@endsection