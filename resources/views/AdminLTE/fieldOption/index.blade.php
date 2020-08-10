@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item active">Параметры опций товара</li>
        </ol>
    </nav>
    <h1>Параметры опции товара</h1><br>
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item"><a class="nav-link {{($type == 'coating')?'active':''}}" href="{{route('fieldOptions.index',['type' => 'coating'])}}"><strong>Цвет покрытия</strong></a></li>
                <li class="nav-item"><a class="nav-link {{($type == 'stone')?'active':''}}" href="{{route('fieldOptions.index',['type' => 'stone'])}}"><strong>Цвет камня</strong></a></li>
                <li class="nav-item"><a class="nav-link {{($type == 'material')?'active':''}}" href="{{route('fieldOptions.index',['type' => 'material'])}}"><strong>Материал</strong></a></li>
            </ul>
        </div>
        <div class="card-body">

            <div class="tab-content">
                <div class="tab-pane active">
                    <span><strong>{{$options[$type]}}</strong></span>&nbsp;&nbsp;
                    <a href="{{route('fieldOptions.create',['type' => $type])}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Добавить
                    </a>
                    <hr>
                    @include('AdminLTE.fieldOption._list')
                </div>
                <!-- /.tab-pane -->
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->



@endsection