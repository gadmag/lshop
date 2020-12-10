@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Форма создания")
<div class="menus">

    <div class="article-body">

        {!! Form::model($menu = new \App\Menu(), ['url' => route('menus.store',['menu_type' => $type])]) !!}
        @include('AdminLTE.menu._form',['submitButtonText' => 'Добавить пункт'])
        {!! Form::close() !!}

    </div>

</div>
@endsection