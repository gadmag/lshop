<p><strong>Номер заказа:</strong> &nbsp;&nbsp;&nbsp;<strong>{{$order->id}}</strong></p>
<p><strong>Дата заказа:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{$order->created_at}}</strong></p>
<p><strong>Имя покупателя:</strong> <strong>{{ $order->last_name}} {{$order->first_name}}</strong></p>
<p><strong>E-mail:</strong> <a href="mailto:{{$order->email}}">{{$order->email}}</a></p>
<p><strong>Телефон:</strong> <a href="tel:{{$order->telephone}}">{{$order->telephone}}</a></p>
<p><strong>Адрес доставки:</strong> <strong>{{$order->country}}</strong> <strong>{{$order->region}}</strong>
    <strong>г. {{$order->city}}</strong></p>
@if($order->postcode)
    <p><strong>Индекс:</strong> <strong>{{$order->postcode}}</strong></p>
@endif
<div style="max-width: 600px">

    <table style="width:100%;border-collapse:collapse;border-spacing:0;empty-cells:show;border:1px solid #cbcbcb"
           cellpadding="0" cellspacing="0" width="100%">
        <thead style="background-color:#e0e0e0;color:#000;text-align:left;vertical-align:bottom">
        <tr>
            <th style="border-width:0 0 1px 0;border-bottom:1px solid #cbcbcb;border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:0.5em 1em">
                Наименование товара
            </th>
            <th style="border-width:0 0 1px 0;border-bottom:1px solid #cbcbcb;border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:0.5em 1em">
                Кол-во
            </th>
            <th style="border-width:0 0 1px 0;border-bottom:1px solid #cbcbcb;border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:0.5em 1em"
                align="right">Цена за шт
            </th>
            <th style="border-width:0 0 1px 0;border-bottom:1px solid #cbcbcb;border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:0.5em 1em"
                align="right">Всего
            </th>
            <th style="border-width:0 0 1px 0;border-bottom:1px solid #cbcbcb;border-left:1px solid #cbcbcb;border-width:0 0 0 1px;font-size:inherit;margin:0;overflow:visible;padding:0.5em 1em"
                align="right">&nbsp;
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($cart->items as $cartItem)
            <tr>
                <td style="">
                    @if ($cartItem['item']->files()->exists())
                        <img class="img-responsive"
                             src="{{asset('storage/files/90x110/'.$cartItem['item']->files()->first()->filename)}}"
                             alt="Картинка товара">
                    @endif
                </td>
                <td style="padding: 5px 0">{{$cartItem['item']['title']}}</td>
                <td style="padding: 5px 0">{{$cartItem['qty']}}</td>
                <td style="padding: 5px 0">{{$cartItem['price']/$cartItem['qty']}} ₽</td>
                <td style="padding: 5px 0" align="right">{{$cartItem['price']}} ₽</td>
            </tr>
        @endforeach
        <tr style="padding: 10px 0">
            <td colspan="4" align="right"><strong>Предварительная стоимость:</strong></td>
            <td align="right">
                <strong>{{$cart->totalPrice}} ₽</strong>
            </td>
        </tr>
        @if($cart->coupon)
            <tr style="padding: 10px 0">
                <td colspan="4" align="right"><strong>Купон:</strong></td>
                <td align="right">
                    <strong>{{$cart->coupon->name}}</strong>
                </td>
            </tr>
            <tr style="padding: 10px 0">
                <td colspan="4" align="right"><strong>Итоговая сумма:</strong></td>
                <td align="right">
                    <strong>{{$cart->totalPrice - $cart->totalPrice*$cart->coupon->discount/100}} р.</strong>
                </td>
            </tr>
        @endif
        </tbody>
    </table>

</div>
<br>
@if($order->comment)
    <div style="background: #e0e0e0; max-width: 300px"><strong>Комментарий к заказу:</strong></div>
    <div class="panel-body">
        {{$order->comment}}
    </div>

@endif
<br>
<div style="background: #e0e0e0; max-width: 300px"><strong>Способ оплаты:</strong></div>
<p class="panel-body">
    {{$order->payment_method}} {{$order->payment_id}}
</p>
</div>