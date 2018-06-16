@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="product-body">
                        @include('errors.list')
                        {!! Form::model($product = new \App\Product, ['url' => route('products.store'),'files' => true, 'class' => 'product']) !!}


                        @include('AdminLTE.product._form', ['submitButtonText' => 'Добавить продукт'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection