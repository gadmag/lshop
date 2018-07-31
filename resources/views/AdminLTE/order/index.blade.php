@extends('AdminLTE.admin')

@section('AdminLTE.content')
    <div class="">
        <h1>Заказы</h1>
        <div class="panel-heading">
        </div>
        @if (count($orders) > 0)
            <div class="panel panel-default">


                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Инициалы</th>
                        <th>Адрес</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <!-- Article title -->
                                <td class="table-link">
                                    <div>{{$order->first_name}} {{$order->last_name}}</div>
                                </td>
                                <td class="table-text">
                                    <span>{{$order->country}} {{$order->region}} @if($order->city) г. {{$order->city}} @endif</span>
                                    <div>{{$order->address}}</div>
                                </td>

                                <td class="table-text">
                                    {{$order->telephone}}
                                </td>

                                <td class="table-text">
                                    {{$order->email}}
                                </td>

                                <!-- Edit Button-->
                                <td class="text-right">
                                    <a href="{{route('order.show', ['id' => $order->id])}}" type="submit" data-toggle="tooltip" title="Просмотр" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$orders->links()}}
                </div>
            </div>

        @endif
    </div>
@endsection