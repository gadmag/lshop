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
        <div class="order-body p-3 mb-3">
            <div class="row mb-3">
                <div class="col-sm-4">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Информация о заказе</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div><strong>Номер заказа:</strong> {{$order->id}}</div>
                            <div><strong>Способ оплаты:</strong> {{$order->payment_method}} {{$order->payment_id}}</div>
                            @foreach($order->cart['coupons'] as $coupon))
                            <div><strong>Купон:</strong> {{$coupon->name}}</div>
                            @endforeach
                            <div><strong>Дата заказа:</strong> {{$order->created_at}}</div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-sm-4">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Информация о покупателе</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div><strong>Инициалы:</strong> {{$order->first_name}} {{$order->last_name}}</div>
                            <div><strong>Почта:</strong> <a href="mailto:{{$order->email}}">{{$order->email}}</a></div>
                            <div><strong>Телефон:</strong> <a href="tel:{{$order->telephone}}">{{$order->telephone}}</a></div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>

                <div class="col-sm-4">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Адрес доставки</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <span>{{$order->country}}, @if($order->region){{$order->region}}, @endif @if($order->city)
                                        г. {{$order->city}} @endif</span>
                            </div>
                            <div>{{$order->address}}</div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box mt-2 box-default ">
{{--                        <div class="box-header with-border">--}}
{{--                            <h3 class="box-title">Товыры</h3>--}}
{{--                        </div><!-- /.box-header -->--}}
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
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <p class="lead">Cумма платежа</p>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Предварительная стоимость:</strong></td>
                            <td class="text-right">{{$order->cart['totalPrice']}} <span class="ruble">&#8381;</span></td>
                        </tr>
                        @if($order->shipment_method)
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{$order->shipment_method}}</strong></td>
                                <td class="text-right">{{$order->shipment_price}} <span class="ruble">&#8381;</span></td>
                            </tr>
                        @endif
                        {{--        @if($order->cart['coupon'])--}}
                        {{--            <tr>--}}
                        {{--                <td colspan="3" class="text-right"><strong>Купон:</strong></td>--}}
                        {{--                <td class="text-right">--}}
                        {{--                    <strong>{{$order->cart['coupon']->name}}</strong>--}}
                        {{--                </td>--}}
                        {{--            </tr>--}}
                        {{--        @endif--}}
                        <tr>
                            <td colspan="3" class="text-right"><strong>Итоговая сумма:</strong></td>
                            <td class="text-right">{{$order->totalPrice}} <span class="ruble">&#8381;</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-right"><i class="fas fa-download"></i> Генерация PDF</button>
                </div>
            </div>
        </div>

    </div>
@endsection