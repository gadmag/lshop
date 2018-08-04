@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <h1>Заказы</h1>
        <div class="panel-heading">
        </div>
        {!! $grid->show('grid-table') !!}
    </div>
@endsection