<div class="">
    <h1>Параметры товаров</h1>
    <div class="panel-heading">
        <a href="{{route('fieldOptions.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить
        </a>
    </div>
    @if (count($fieldOptions) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Имя</th>
                    <th>Тип</th>
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


                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\FieldOptionController@edit',[$fieldOption->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/fieldOptions/'.$fieldOption->id) }}" method="POST">
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
                {{$fieldOptions->links()}}
            </div>
        </div>

    @endif
</div>