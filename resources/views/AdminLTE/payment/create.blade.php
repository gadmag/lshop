@extends('AdminLTE.admin')

@section('AdminLTE.content')

    <div class="">

        <h1 class="heading">Форма создания</h1>

        <div class="article-body">
            @include('errors.list')
            {!! Form::model($payment = new \App\Payment, ['url' => route('payments.store'), 'files' => true, 'class' => 'payment']) !!}

            @include('AdminLTE.payment._form',['submitButtonText' => 'Добавить оплаты'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection