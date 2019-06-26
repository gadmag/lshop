@extends('AdminLTE.admin')

@section('AdminLTE.content')

{{--@include('AdminLTE.product._list_product')--}}
<h1>Услуги</h1>
<div class="panel-heading">
    <a href="{{route('services.create')}}" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Добавить услугу
    </a>
</div>
{!! $grid->show('grid-table') !!}

@endsection