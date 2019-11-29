@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">
        <h1 class="heading">Редактировать: {{$payment->title}}</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($payment, ['method' => 'PATCH', 'action' => ['Admin\PaymentController@update', $payment->id], 'files' => true, 'class' => 'payment']) !!}

            @include('AdminLTE.payment._form',['submitButtonText' => 'Сохранить оплату'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection