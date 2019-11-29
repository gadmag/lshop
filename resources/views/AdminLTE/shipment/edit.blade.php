@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <h1 class="heading">Редактировать: {{$shipment->title}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($shipment, ['method' => 'PATCH', 'action' => ['Admin\ShipmentController@update', $shipment->id], 'files' => true, 'class' => 'shipment']) !!}

            @include('AdminLTE.shipment._form',['submitButtonText' => 'Сохранить страницу'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection