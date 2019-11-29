@if(count($orders) > 0)
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Последние заказы</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>Заказ ID</th>
                        <th>Имя</th>
                        <th>Статус заказа</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><a href="{{route('orders.show',[$order->id])}}">{{$order->id}}</a></td>
                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                            <td><span class="label label-{{$order->status->css_class}}">{{$order->status->name}} {{$order->css_class}}</span></td>
                            <td>{{$order->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="{{route('orders.create')}}" class="btn btn-sm btn-info btn-flat pull-left">Добавить заказ</a>
            <a href="{{route('orders.index')}}" class="btn btn-sm btn-default btn-flat pull-right">Показать все
                заказы</a>
        </div>
        <!-- /.box-footer -->
    </div>
@endif