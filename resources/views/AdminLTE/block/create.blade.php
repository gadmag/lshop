@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($block = new \App\Block, ['url' => route('blocks.store'), 'class' => 'block']) !!}

                            @include('AdminLTE.block._form',['submitButtonText' => 'Добавить блок'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection