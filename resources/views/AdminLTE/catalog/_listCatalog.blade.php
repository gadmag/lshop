<div class="">
    <h1>Каталог</h1>
    <div class="panel-heading">
        <a href="{{route('catalogs.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить категорию
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="list-unstyled">
            @each('AdminLTE.catalog._list_item', $catalogs, 'catalog')
            </ul>
        </div>
    </div>

</div>