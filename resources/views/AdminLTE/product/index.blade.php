@extends('AdminLTE.admin')

@section('AdminLTE.content')

{{--@include('AdminLTE.product._list_product')--}}
{!! $grid->show('grid-table') !!}

@endsection