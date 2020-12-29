@extends('AdminLTE.admin')

@section('AdminLTE.content')

<div class="card card-primary">
    <div class="card-header">
        <div class="float-right"><strong>Всего товаров: {{$products->count()}}</strong></div>
        <h4 class="mt-0">Продукты</h4>
    </div>
    <div class="card-body">
        <div class="float-right mb-4">
            <a href="{{route('products.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Добавить запись
            </a>
        </div>
        <div class="clearfix"></div>
        {!! $grid->show('grid-table') !!}
    </div>
</div>
@endsection