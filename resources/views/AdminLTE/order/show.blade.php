@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="order">
        <nav aria-label="breadcrumb" role="navigation">
            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Заказы</a></li>
                <li class="breadcrumb-item active" aria-current="page">Номер заказа {{$order->id}}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-sm-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация о заказе</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p><strong>Номер заказа:</strong> {{$order->id}}</p>
                        <p><strong>Способ оплаты:</strong> {{$order->payment_method}} {{$order->payment_id}}</p>
                        @foreach($order->cart['coupons'] as $coupon))
                        <p><strong>Купон:</strong> {{$coupon->name}}</p>
                        @endforeach
                        <p><strong>Дата заказа:</strong> {{$order->created_at}}</p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-sm-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация о покупателе</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p><strong>Инициалы:</strong> {{$order->first_name}} {{$order->last_name}}</p>
                        <p><strong>Почта:</strong> <a href="mailto:{{$order->email}}">{{$order->email}}</a></p>
                        <p><strong>Телефон:</strong> <a href="tel:{{$order->telephone}}">{{$order->telephone}}</a></p>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>

            <div class="col-sm-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Адрес доставки</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>
                            <span>{{$order->country}}, @if($order->region){{$order->region}}, @endif @if($order->city)
                                    г. {{$order->city}} @endif</span>
                        <div>{{$order->address}}</div>
                        </p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Товыры</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        @include('cart.table')

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
            <div class="col-md-4">
                @if($order->comment)
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Комментарий к заказу</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                           {{$order->comment}}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                @endif
            </div>


        </div>
    </div>
@endsection