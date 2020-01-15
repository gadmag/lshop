@extends('AdminLTE.admin')

@section('AdminLTE.content')

    @push('scripts')
        <script src="{{elixir('/js/jquery.colorbox.js')}}"></script>
        <script>
            $(document).ready(function () {
                $(".group1").colorbox({
                    rel: 'group1',
                    current: 'Фото {current} из {total}',
                    maxWidth: '95%',
                    maxHeight: '95%'
                });
            });
        </script>

    @endpush
    @push('style')
        <link href="{{elixir('/css/colorbox.css')}}" rel="stylesheet">
    @endpush
    <div class="order">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Заказы</a></li>
                <li class="breadcrumb-item active" aria-current="page">Заказ №{{$order->id}}</li>
            </ol>
        </nav>
        <h1 class="heading">Редактировать заказ: №{{$order->id}}</h1>

        <div class="order-body">
            @include('errors.list')
            {!! Form::model($order, ['method' => 'PUT', 'action' => ['Admin\OrderController@update', $order->id], 'class' => 'order']) !!}

            @include('AdminLTE.order._form',['submitButtonText' => 'Сохранить изменеия'])

            {!! Form::close() !!}

        </div>
    </div>
@endsection
