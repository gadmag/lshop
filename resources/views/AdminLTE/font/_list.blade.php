<div class="">
    @if (count($fonts) > 0)
        <table class="table table-striped task-table">

            <!-- Table Headings -->
            <thead>
            <th>Название шрифта</th>
            <th>Код</th>
            </thead>

            <!-- Table Body -->
            <tbody>
            @foreach ($fonts as $font)
                <tr>

                    <td class="table-text">
                        <span>{{$font->title}}</span>
                    </td>

                    <td class="table-text">
                        <span>{{$font->code}}</span>
                    </td>


                    <!-- Edit Button-->
                    <td class="text-right">

                        <a style="display: inline-block"
                           href="{{action('Admin\FontController@edit',[$font->id])}}"
                           class="btn btn-info" title="Редактировать"
                           data-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>


                        <!-- Delete Button -->

                        <form style="display: inline-block"
                              action="{{action('Admin\FontController@destroy',[$font->id])}}"
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
        {{$fonts->links()}}

    @endif
</div>