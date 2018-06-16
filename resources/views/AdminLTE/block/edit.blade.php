@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <h1 class="heading">Редактировать: {{$block->title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($block, ['method' => 'PATCH', 'action' => ['Admin\BlockController@update', $block->id], 'class' => 'block']) !!}

                            @include('AdminLTE.block._form',['submitButtonText' => 'Сохранить блок'])
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection