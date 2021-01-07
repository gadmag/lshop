@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title',"Редактировать: {$payment->title}")
<div class="article-body">
    {!! Form::model($payment, ['method' => 'PATCH', 'action' => ['Admin\PaymentController@update', $payment->id], 'files' => true, 'class' => 'payment']) !!}

    @include('AdminLTE.payment._form',['submitButtonText' => 'Сохранить оплату'])

    {!! Form::close() !!}

</div>
@endsection