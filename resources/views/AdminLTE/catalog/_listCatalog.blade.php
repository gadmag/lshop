<div class="">
    <h1>Каталог</h1>
    <div class="panel-heading">
        <a href="{{route('catalogs.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить категорию
        </a>
    </div>
    <div class="col-md-8">
        <div class="">
            <ul class="menu-link list-unstyled">
            @each('AdminLTE.catalog._list_item', $catalogs, 'catalog')
            </ul>
        </div>
    </div>

    <div class="col-md-4"></div>
    <div class="clearfix"></div>

</div>