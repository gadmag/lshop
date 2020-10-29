<div class="row">
    <div class="col-md-8 page-default">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary ">
                    <div class="card-header">
                        <h3 class="card-title">Информация о оплате</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('payment_title', 'Платежная система:') !!}
                            {!! Form::text('payment_title', $order->payment->title, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('payment_id', 'Ключ оплаты:') !!}
                            {!! Form::text('payment_key', $order->payment->payment_key, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card card-primary ">
                    <div class="card-header">
                        <h3 class="card-title">Информация пользователя</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('first_name', 'Имя:') !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name', 'Фамилия:') !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('telephone', 'Телефон:') !!}
                            {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
                        </div>

                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card card-primary ">
                    <div class="card-header">
                        <h3 class="card-title">Адрес доставки</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('country', 'Страна:') !!}
                            {!! Form::text('country', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('region', 'Регион:') !!}
                            {!! Form::text('region', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('city', 'Город:') !!}
                            {!! Form::text('city', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', 'Адрес:') !!}
                            {!! Form::text('address', null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div><!-- /row -->
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title">Товары</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <order :products="{{$products}}" :fonts="{{$fonts}}" :order="{{collect($order)}}"
                       :shipments="{{$shipments}}" :coupons="{{$coupons}}"
                       :payment_config="{{$payment_config}}"></order>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Email</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="is_send" type="hidden" value="0">
                                <input id="is_send" name="is_send" type="checkbox"  class="custom-control-input" value="1">
                                <label for="is_send" class="custom-control-label">Отправить счет пользователю:</label>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Статус заказа</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('order_status_id', 'Выбрать статус') !!}
                            {!! Form::select('order_status_id', $orderStatus, null, ['class' => 'form-control', 'placeholder' => 'Выбрать статус']) !!}

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div>



    </div>

    <div class="col-md-3 pull-right">
        <div class="card card-primary ">
            <div class="card-header">
                <h4 class="card-title">Добавить комментарий администратора</h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('comment_admin', 'Комментарий:') !!}
                    {!! Form::textarea('comment_admin', null, ['class' => 'form-control']) !!}
                </div>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        @if($order->comment)
            <div class="card card-default ">
                <div class="card-header">
                    <h3 class="card-title">Комментарий покупателя</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    {{$order->comment}}
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        @endif
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
