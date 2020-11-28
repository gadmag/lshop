@extends('AdminLTE.admin')

@section('AdminLTE.content')

        <div class="catalog-body">
            @include('errors.list')
            {!! Form::model($catalog = new \App\Catalog, ['url' => route('catalogs.store'),'files' => true, 'class' => 'catalog']) !!}


            @include('AdminLTE.catalog._form', ['title' => 'Создание категории','submitButtonText' => 'Добавить категорию'])

            {!! Form::close() !!}

        </div>


@endsection