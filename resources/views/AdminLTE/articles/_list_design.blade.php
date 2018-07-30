<div class="">
    <h1>{{$articleType->title}}</h1>
    <div class="panel-heading">
        <a href="{{route('create', ['type' => $articleType->name])}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить галерею
        </a>
    </div>
    @if (count($articles) > 0)
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
                    @foreach ($articles as $article)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <span>{{$article->title}}</span>
                            </td>
                            <td class="table-text">
                                <span>{{$article->published_at}}</span>
                            </td>

                            <td class="table-text">
                                @if($article->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Нет</span>
                                @endif
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\ArticleController@edit',[$article->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/articles/'.$article->id) }}" method="POST">
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
                {{$articles->links()}}
            </div>
        </div>

    @endif
</div>