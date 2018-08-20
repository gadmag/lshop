<div style="background: #FFFFFF" class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Наименование товара</th>
            <th>Кол-во</th>
            <th class="text-right">Цена за шт</th>
            <th class="text-right">Всего</th>
        </tr>
        </thead>
        <tbody>

        @foreach($order->cart->items as $item)
            <tr>
                <td>{{$item['item']['title']}}</td>
                <td><strong>{{$item['qty']}}</strong></td>
                <td>{{$item['price']/$item['qty']}} р.</td>
                <td class="text-right">{{$item['price']}} р.</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" class="text-right"><strong>Предварительная стоимость:</strong></td>
            <td class="text-right">
                <strong>{{$order->cart->totalPrice}} р.</strong>
            </td>
        </tr>
        @if($order->shipment_method)
            <tr>
                <td colspan="3" class="text-right"><strong>{{$order->shipment_method}}</strong></td>
                <td class="text-right">
                    <strong>{{$order->shipment_price}}</strong>
                </td>
            </tr>
        @endif
        @if($order->cart->coupon)
            <tr>
                <td colspan="3" class="text-right"><strong>Купон:</strong></td>
                <td class="text-right">
                    <strong>{{$order->cart->coupon->name}}</strong>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="3" class="text-right"><strong>Итоговая сумма:</strong></td>
            <td class="text-right">
                <strong>{{$order->totalPrice}}р.</strong>
            </td>
        </tr>
        </tbody>
    </table>

</div>