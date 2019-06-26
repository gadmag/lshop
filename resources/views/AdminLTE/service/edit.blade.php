@extends('AdminLTE.admin')

@section('AdminLTE.content')


    <div class="product">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('services.index')}}">Услуги</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать: {{$product->title}}</h1>

        <div class="product-body">
            @include('errors.list')
            {!! Form::model($product, ['method' => 'PATCH', 'action' => ['Admin\ServiceController@update', $product->id],'files' => true, 'class' => 'article','autocomplete' => 'off']) !!}

            @include('AdminLTE.service._form', ['submitButtonText' => 'Сохранить услугу'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection