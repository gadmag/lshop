@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">

        <h1 class="heading">Форма создания</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($shipment = new \App\Shipment, ['url' => route('shipments.store'), 'files' => true, 'class' => 'page']) !!}

            @include('AdminLTE.shipment._form',['submitButtonText' => 'Добавить доставку'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection