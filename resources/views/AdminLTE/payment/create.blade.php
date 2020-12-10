@extends('AdminLTE.admin')

@section('AdminLTE.content')
@section('title','Форма создания')
<div class="article-body">
    {!! Form::model($payment = new \App\Payment, ['url' => route('payments.store'), 'files' => true, 'class' => 'payment']) !!}

    @include('AdminLTE.payment._form',['submitButtonText' => 'Добавить оплаты'])

    {!! Form::close() !!}

</div>

@endsection