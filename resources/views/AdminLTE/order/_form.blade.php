
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
                        <h3 class="box-title">Информация о доставке</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('shipment_method', 'Способ доставки:') !!}
                            {!! Form::text('shipment_method', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('shipment_price', 'Стоимость:') !!}
                            {!! Form::text('shipment_price', null, ['class' => 'form-control']) !!}
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
                <order :products="{{$products}}" :cart="{{collect($order->cart)}}"></order>
                <div class="form-group">
                    {!! Form::label('totalPrice', 'Итоговая сумма:') !!}
                    {!! Form::text('totalPrice', null, ['class'=>'form-control']) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->




    </div>

    <div class="col-md-3 pull-right">
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title">Комментарий</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('comment', 'Комментарий:') !!}
                    {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    {{Form::submit($submitButtonText,['class' => 'btn btn-primary'])}}

</div>
