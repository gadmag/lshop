@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать категорию: {{$catalog->name}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($catalog, ['method' => 'PATCH', 'action' => ['Admin\CatalogController@update', $catalog->id],'files' => true, 'class' => 'catalog']) !!}
                        
                            @include('AdminLTE.catalog._form', ['submitButtonText' => 'Сохранить продукт'])
                        
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection