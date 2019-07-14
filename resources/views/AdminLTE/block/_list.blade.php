<div class="">
    @if (count($blocks) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Заголовок</th>
                    <th>Регион</th>
                    <th>Статус</th>
                    <th>Вес</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($blocks as $block)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <div><a href="{{action('Admin\BlockController@edit', [$block->id])}}">{{$block->title}}</a></div>
                            </td>
                            <td class="table-text">
                                <span>{{$block->region}}</span>
                            </td>

                            <td class="table-text">
                                @if($block->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Нет</span>
                                @endif
                            </td>

                            <td class="table-text">
                                {{$block->weight}}
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\BlockController@edit',[$block->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/blocks/'.$block->id) }}" method="POST">
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
                {{$blocks->links()}}
            </div>
        </div>

    @endif
</div>