<div class="">
    <h1>Каталог</h1>
    <div class="panel-heading">
        <a href="{{route('catalog.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить категорию
        </a>
    </div>
    @if (count($catalogs) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Заголовок</th>
                    <th>Адрес</th>
                    <th>Статус</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($catalogs as $catalog)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <div><a href="{{action('Admin\CatalogController@edit', [$catalog->id])}}">{{$catalog->name}}</a></div>
                            </td>
                            <td class="table-text">
                                <span>{{$catalog->alias}}</span>
                            </td>


                            <td class="table-text">
                                @if($catalog->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Нет</span>
                                @endif
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\CatalogController@edit',[$catalog->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/catalog/'.$catalog->id) }}" method="POST">
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
                {{$catalogs->links()}}
            </div>
        </div>

    @endif
</div>