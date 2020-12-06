@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('catalogs.index')}}">Каталог</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$catalog->name}}</li>
            </ol>
        </nav>
        <div class="article-body">
            @include('errors.list')
            {!! Form::model($catalog, ['method' => 'PATCH', 'action' => ['Admin\CatalogController@update', $catalog->id],'files' => true, 'class' => 'catalog']) !!}

            @include('AdminLTE.catalog._form', [ 'title' => 'Редактировать категорию: '.$catalog->name, 'submitButtonText' => 'Сохранить продукт'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection