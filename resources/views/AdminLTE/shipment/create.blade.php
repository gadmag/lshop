@extends('AdminLTE.admin')

@section('title','Форма создания')
@section('AdminLTE.content')
    <div class="shipments">
        <div class="article-body">
            {!! Form::model($shipment = new \App\Shipment, ['url' => route('shipments.store'), 'files' => true, 'class' => 'page']) !!}

            @include('AdminLTE.shipment._form',['submitButtonText' => 'Добавить доставку'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection