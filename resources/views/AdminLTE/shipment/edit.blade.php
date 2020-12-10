@extends('AdminLTE.admin')

@section('title', "Редактировать: {$shipment->title}")
@section('AdminLTE.content')
    <div class="shipments">
        <div class="article-body">
            {!! Form::model($shipment, ['method' => 'PATCH', 'action' => ['Admin\ShipmentController@update', $shipment->id], 'files' => true, 'class' => 'shipment']) !!}

            @include('AdminLTE.shipment._form',['submitButtonText' => 'Сохранить страницу'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection