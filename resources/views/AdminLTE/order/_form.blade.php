
<div class="row">
{{--    {!! dd($order->cart) !!}--}}
    <div class="col-md-8 page-default">

        <div class="row">
            <div class="col-md-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация о оплате</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('payment_method', 'Метод оплаты:') !!}
                            {!! Form::text('payment_method', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('payment_id', 'id оплаты:') !!}
                            {!! Form::text('payment_id', null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация пользователя</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
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

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-4">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Адрес доставки</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
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
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div><!-- /row -->
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title">Товары</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <order :products="{{$products}}" :order="{{collect($order)}}" :coupons="{{$coupons}}" :payment_config="{{$payment_config}}"></order>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title">Email</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('is_send', 'Отправить счет пользователю:') !!}
                    {{Form::hidden('is_send',0)}}
                    {!! Form::checkbox('is_send') !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


    </div>

    <div class="col-md-3 pull-right">
        <div class="box box-default ">
            <div class="box-header with-border">
                <h4 class="box-title">Добавить комментарий администратора</h4>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('comment_admin', 'Комментарий:') !!}
                    {!! Form::textarea('comment_admin', null, ['class' => 'form-control']) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        @if($order->comment)
            <div class="box box-default ">
                <div class="box-header with-border">
                    <h3 class="box-title">Комментарий покупателя</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {{$order->comment}}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        @endif
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
