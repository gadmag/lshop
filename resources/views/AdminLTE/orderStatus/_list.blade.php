<div class="">
    @if (count($orderStatus) > 0)
        <table class="table table-striped task-table">

            <!-- Table Headings -->
            <thead>
            <th>Название</th>
            </thead>

            <!-- Table Body -->
            <tbody>
            @foreach ($orderStatus as $status)
                <tr>

                    <td class="table-text">
                        <span>{{$status->name}} @if($status->is_default)<strong>(по умолчанию)</strong>@endif</span>
                    </td>

                    <!-- Edit Button-->
                    <td class="text-right">

                        <a style="display: inline-block"
                           href="{{action('Admin\OrderStatusController@edit',[$status->id])}}"
                           class="btn btn-info" title="Редактировать"
                           data-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>


                        <!-- Delete Button -->

                        <form style="display: inline-block"
                              action="{{action('Admin\OrderStatusController@destroy',[$status->id])}}"
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
        {{$orderStatus->links()}}

    @endif
</div>