@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($fieldOption = new \App\FieldOption(), ['url' => route('fieldOptions.store'), 'class' => 'block']) !!}

                            @include('AdminLTE.fieldOption._form',['submitButtonText' => 'Добавить значение'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection