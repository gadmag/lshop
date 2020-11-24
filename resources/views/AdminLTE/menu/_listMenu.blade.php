<div class="card cf nestable-lists">

    <div class="card-header">
        <a href="{{route('menus.create',['menu_type' => $type])}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить пункт меню
        </a>
    </div>
    <div class="card-body">
        <nestable :tree-data="{{$menuItems}}"
                  route-update="{{route('menus.updateTree')}}">
        </nestable>

        <br>
        <textarea class="form-control" id="nestable-output"></textarea>
    </div>

</div>



