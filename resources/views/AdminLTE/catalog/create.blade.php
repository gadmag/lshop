@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title','Каталог')
<div class="catalog-body">
    {!! Form::model($catalog = new \App\Catalog, ['url' => route('catalogs.store'),'files' => true, 'class' => 'catalog']) !!}
    @include('AdminLTE.catalog._form', ['title' => 'Создание категории','submitButtonText' => 'Добавить категорию'])
    {!! Form::close() !!}

</div>

@endsection