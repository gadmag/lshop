<div class="">
    @if (count($services) > 0)
        <table class="table table-striped task-table">

            <!-- Table Headings -->
            <thead>
            <th>Название</th>
            <th>Тип</th>
            <th>Порядок сортировки</th>
            </thead>

            <!-- Table Body -->
            <tbody>
            @foreach ($services as $service)
                <tr>

                    <td class="table-text">
                        <span>{{$service->title}}</span>
                    </td>

                    <td class="table-text">
                        <span>{{$service->type}}</span>
                    </td>
                    <td class="table-text">
                        <span>{{$service->order}}</span>
                    </td>


                    <!-- Edit Button-->
                    <td class="text-right">

                        <a style="display: inline-block"
                           href="{{action('Admin\ServiceController@edit',[$service->id,'type' => $type])}}"
                           class="btn btn-info" title="Редактировать"
                           data-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>


                        <!-- Delete Button -->

                        <form style="display: inline-block"
                              action="{{action('Admin\ServiceController@destroy',[$service->id, 'type' => $type ])}}"
                              method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}

                            <button style="display: inline-block" type="submit" class="btn btn-danger"
                                    data-toggle="tooltip" title="Удалить">
                                <i class="fa fa-trash"></i> Удалить
                            </button>
                        </form>


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$services->links()}}

    @endif
</div>