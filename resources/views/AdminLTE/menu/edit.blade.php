@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Редактировать {$menu->link_title}")
<div class="menus">
    <div class="article-body">
        {!! Form::model($menu , ['method' => 'PATCH', 'action' => ['Admin\MenuController@update', $menu->id]]) !!}
        @include('AdminLTE.menu._form',['submitButtonText' => 'Сохранить'])
        {!! Form::close() !!}

    </div>

</div>
@endsection