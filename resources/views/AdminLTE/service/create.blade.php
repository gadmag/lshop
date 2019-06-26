@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="product">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active">Услуги</li>
            </ol>
        </nav>

        <h1 class="heading">Добавить услугу</h1>

        <div class="product-body">
            @include('errors.list')
            {!! Form::model($product = new \App\Product, ['url' => route('services.store'),'files' => true, 'class' => 'product', 'autocomplete' => 'off']) !!}

            @include('AdminLTE.service._form', ['submitButtonText' => 'Добавить услугу'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection