@extends('AdminLTE.admin')

@section('AdminLTE.content')


    <div class="product">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Продукты</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать: {{$product->title}}</h1>

        <div class="product-body">
            @include('errors.list')
            {!! Form::model($product, ['method' => 'PATCH', 'action' => ['Admin\ProductController@update', $product->id],'files' => true, 'id' => 'productForm', 'autocomplete' => 'off']) !!}

            @include('AdminLTE.product._form', ['submitButtonText' => 'Сохранить продукт'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection