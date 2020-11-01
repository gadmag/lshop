<div style="background: #FFFFFF" class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Наименование товара</th>
            <th>Кол-во</th>
            <th>Цена за шт</th>
            <th>Всего</th>
        </tr>
        </thead>
        <tbody>

        @foreach($order->cart['content'] as $item)
            <tr>
                <td>
                    <div class="p-2">
                        <a href="/storage/files/600x450/{{$item->image}}" class="group1">
                            <img src="/storage/files/90x110/{{$item->image}}" class="img-fluid rounded shadow-sm" width="80" alt="Фото товара">
                        </a>
                        <div class="ml-3 d-inline-block align-middle">
                            <div class="mb-0">
                                <span href="#" class="text-dark d-inline-block align-middle">{{$item->name}}</span>
                            </div>
                            @if($item->options['color'])
                                <span class="text-muted d-block">Цвет: {{$item->options['color']}}</span>
                            @endif
                            @if($item->options['color_stone'])
                                <span class="text-muted d-block">Цвет камня: {{$item->options['color_stone']}}</span>
                            @endif
                            @if($item->engravings && count($item->engravings) > 0)
                                <div id="engravingCart" class="callout callout-default engraving-list">
                                    <b>Гравировка:</b>
                                    @foreach($item->engravings as $engraving)
                                        <div class="text-left d-flex" >
                                            <div class="dropdown flex-fill text-left">
                                                <span class="title">{{$engraving->title}}</span>
                                                <span class="font">{{$engraving->font}}</span>
                                            </div>
                                            <div class="flex-fill ml-3 text-right">
                                                <span class="qty">{{$engraving->qty}}x</span>
                                                <span class="price">{{$engraving->price}} &#8381;</span>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </td>
                <td>{{$item->qty}}</td>
                <td>{{$item->price/$item->qty}} <span class="ruble">&#8381;</span></td>
                <td>{{$item->price}} <span class="ruble">&#8381;</span></td>
            </tr>
        @endforeach

        </tbody>
    </table>

</div>