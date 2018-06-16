@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">
{{--{!! dd($menu) !!}--}}
                    <h1 class="heading">Редактировать {{$menu->link_title}}</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($menu , ['method' => 'PATCH', 'action' => ['Admin\MenuController@update', $menu->id]]) !!}
                        @include('AdminLTE.menu._form',['submitButtonText' => 'Сохранить'])
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection