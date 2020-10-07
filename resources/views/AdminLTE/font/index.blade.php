@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <nav aria-label="breadcrumb" role="navigation">
        <br>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
            <li class="breadcrumb-item active">Услуга товара</li>
        </ol>
    </nav>
    <h1>Услуга товара</h1><br>
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item"><a class="nav-link" href="{{route('services.index',['type' => 'engraving'])}}"><strong>Гравировка</strong></a></li>
                <li class="nav-item"><a class="nav-link active" href="{{route('fonts.index',['type' => 'fonts'])}}"><strong>Шрифты</strong></a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active">
                    <a href="{{route('fonts.create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Добавить
                    </a>
                    <hr>
                    @include('AdminLTE.font._list')
                </div>
                <!-- /.tab-pane -->
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->



@endsection