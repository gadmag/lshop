@extends('AdminLTE.admin')

@section('AdminLTE.content')

<h1>Продукты</h1>
<div class="panel-heading">
    <div class="row">
        <div class="col-sm-8">
            <a href="{{route('products.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Добавить запись
            </a>
        </div>
        <div class="col-sm-4"> <p class="text-center" style="font-size: 16px;">Всего товаров:&nbsp; <strong>{{$products->count()}}</strong></p></div>
    </div>
</div>
{!! $grid->show('grid-table') !!}
@endsection