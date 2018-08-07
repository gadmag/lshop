@extends('AdminLTE.admin')

@section('AdminLTE.content')

{{--@include('AdminLTE.product._list_product')--}}
<h1>Продукты</h1>
<div class="panel-heading">
    <a href="{{route('products.create')}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить запись
    </a>
</div>
{!! $grid->show('grid-table') !!}

@endsection