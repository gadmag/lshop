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
                            <h3 class="box-title">Отправитель</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <strong>{{config('app.name')}}</strong>
                            <div>{{config('payment.address')}}</div>
                            <div>Email: {{config('payment.send_mail')}}</div>
                            <div>Телефон: {{config('payment.phone')}}</div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-sm-4">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Получатель</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <strong>{{$order->first_name}} {{$order->last_name}}</strong>
                            <div>
                                <span>{{$order->country}}, @if($order->region){{$order->region}}, @endif @if($order->city)
                                        г. {{$order->city}} @endif</span>
                            </div>
                            <div>{{$order->address}}</div>
                            <div>Телефон: {{$order->telephone}}</div>
                            <div>Email: {{$order->email}}</div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>

                <div class="col-sm-4">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Счет #{{$order->id}}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div><strong>Номер счета:</strong> {{$order->id}}</div>
                            <div><strong>Способ оплаты:</strong> {{$order->payment_method}} {{$order->payment_id}}</div>
                            <div><strong>Дата заказа:</strong> {{$order->created_at->format('Y-m-y')}}</div>

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
                        @if($order->cart['coupon'])
                            <tr>
                                <td colspan="3" class="text-right"><strong>Купон:</strong></td>
                                <td class="text-right">
                                    <strong>{{$order->cart['coupon']->name}}</strong>
                                </td>
                            </tr>
                        @endif
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
{{--                    <button class="btn btn-primary float-right"><i class="fas fa-download"></i> Генерация PDF</button>--}}
                </div>
            </div>
        </div>

    </div>
@endsection