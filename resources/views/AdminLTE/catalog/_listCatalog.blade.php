<div class="col-md-8">
    <div class="card card-primary">
        <div class="card-header">Каталог</div>
        <div class="card-body">
            <div class="panel-heading">
                <a href="{{route('catalogs.create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Добавить категорию
                </a>
            </div>
            <div class="">
                <ul class="menu-link list-unstyled">
                    @each('AdminLTE.catalog._list_item', $catalogs, 'catalog')
                </ul>
            </div>
        </div>
    </div>
</div>