<div class="">
    <h1>Страницы</h1>
    <div class="panel-heading">
        <a href="{{route('shipments.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить запись
        </a>
    </div>
    @if (count($shipments) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Заголовок</th>
                    <th>Дата добавления</th>
                    <th>Статус</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($shipments as $shipment)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <div><a href="{{action('Admin\ShipmentController@edit', [$shipment->id])}}">{{$shipment->title}}</a></div>
                            </td>
                            <td class="table-text">
                                <span>{{$shipment->created_at}}</span>
                            </td>

                            <td class="table-text">
                                @if($shipment->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Не опубликованно</span>
                                @endif
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\ShipmentController@edit',[$shipment->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/shipments/'.$shipment->id) }}" method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}

                                    <button style="display: inline-block" type="submit" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i> Удалить
                                    </button>
                                </form>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$shipments->links()}}
            </div>
        </div>

    @endif
</div>