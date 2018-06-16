@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <div class="">
            <div class="">
                <div class="">

                    <h1 class="heading">Форма создания</h1>

                    <div class="article-body">
                        @include('errors.list')
                        {!! Form::model($menu = new \App\Menu(), ['url' => route('menu.store',['menu_type' => $type])]) !!}
                            @include('AdminLTE.menu._form',['submitButtonText' => 'Добавить пункт'])
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection