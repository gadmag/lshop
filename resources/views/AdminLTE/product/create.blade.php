@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="product">

        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Продукты</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавление товара</li>
            </ol>
        </nav>
        <h1 class="heading">Добавление товара</h1>

        <div class="product-body">
            @include('errors.list')
            {!! Form::model($product = new \App\Product, ['url' => route('products.store'),'files' => true, 'id' => 'productForm', 'autocomplete' => 'off']) !!}


            @include('AdminLTE.product._form', ['submitButtonText' => 'Добавить продукт'])

            {!! Form::close() !!}

        </div>
    </div>

@endsection