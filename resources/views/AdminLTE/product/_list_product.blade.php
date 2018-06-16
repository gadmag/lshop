<div class="">
    <h1>Продукты</h1>
    <div class="panel-heading">
        <a href="{{route('products.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить запись
        </a>
    </div>
    @if (count($products) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Заголовок</th>
                    <th>Дата добавления</th>
                    <th>Категория</th>
                    <th>Статус</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <div><a href="{{action('Admin\ProductController@edit', [$product->id])}}">{{$product->title}}</a></div>
                            </td>
                            <td class="table-text">
                                <span>{{$product->published_at}}</span>
                            </td>
                            <td class="table-text">
                                @foreach($product->catalogs as $catalog)

                                    <li><a href="{{action('Admin\CatalogController@edit',[$catalog->name])}}">{{$catalog->name}}</a></li>
                                @endforeach
                            </td>

                            <td class="table-text">
                                @if($product->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Нет</span>
                                @endif
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\ProductController@edit',[$product->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/products/'.$product->id) }}" method="POST">
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
                {{$products->links()}}
            </div>
        </div>

    @endif
</div>