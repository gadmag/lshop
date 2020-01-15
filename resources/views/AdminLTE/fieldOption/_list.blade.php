<div class="">
    @if (count($fieldOptions) > 0)
        <table class="table table-striped task-table">

            <!-- Table Headings -->
            <thead>
            <th>Название</th>
            <th>Тип</th>
            <th>Порядок сортировки</th>
            </thead>

            <!-- Table Body -->
            <tbody>
            @foreach ($fieldOptions as $fieldOption)
                <tr>

                    <td class="table-text">
                        <span>{{$fieldOption->name}}</span>
                    </td>

                    <td class="table-text">
                        <span>{{$fieldOption->type}}</span>
                    </td>
                    <td class="table-text">
                        <span>{{$fieldOption->order}}</span>
                    </td>


                    <!-- Edit Button-->
                    <td class="text-right">

                        <a style="display: inline-block"
                           href="{{action('Admin\FieldOptionController@edit',[$fieldOption->id,'type' => $type])}}"
                           class="btn btn-info" title="Редактировать"
                           data-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>


                        <!-- Delete Button -->

                        <form style="display: inline-block"
                              action="{{action('Admin\FieldOptionController@destroy',[$fieldOption->id, 'type' => $type ])}}"
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
        {{$fieldOptions->links()}}

    @endif
</div>