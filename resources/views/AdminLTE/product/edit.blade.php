@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать: {{$product->title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($product, ['method' => 'PATCH', 'action' => ['Admin\ProductController@update', $product->id],'files' => true, 'class' => 'article']) !!}
                        
                            @include('AdminLTE.product._form', ['submitButtonText' => 'Сохранить продукт'])
                        
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection