@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item active">Услуги товара</li>
        </ol>
    </nav>
    <h1>Услуги товара</h1><br>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="{{($type == 'engraving')?'active':''}}"><a href="{{route('services.index',['type' => 'engraving'])}}"><strong>Цвет покрытия</strong></a></li>
            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                    <span><strong>{{$options[$type]}}</strong></span>&nbsp;&nbsp;
                    <a href="{{route('services.create',['type' => $type])}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Добавить
                    </a>
                <hr>
                @include('AdminLTE.service._list')
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->



@endsection