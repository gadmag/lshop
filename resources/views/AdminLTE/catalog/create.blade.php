@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Создание категории</h1>

                    <div class="catalog-body">
                        @include('errors.list')
                        {!! Form::model($catalog = new \App\Catalog, ['url' => route('catalog.store'),'files' => true, 'class' => 'catalog']) !!}


                        @include('AdminLTE.catalog._form', ['submitButtonText' => 'Добавить категорию'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection