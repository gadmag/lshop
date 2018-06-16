<li class="dd-item dd3-item" data-id="{{$menuItem['id']}}">
    <div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menuItem['link_title']  }}</div>
    <div class="dd3-content-right">
        <div class="dd3-content-path">
            {{$menuItem['path']}}
        </div>
        <div class="dd3-content-edit">
            <!-- edit menu item  -->
            <a style="display: inline-block" href="{{action('Admin\MenuController@edit',[$menuItem['id']])}}" class="edit" title="Редактировать"
               data-toggle="tooltip">
                <i class="fa fa-edit"></i>
            </a>
            <!-- delete menu item -->
            <form style="display: inline-block" action="{{ action('Admin\MenuController@destroy', $menuItem['id'] ) }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}

                <button style="display: inline-block" type="submit" class="btn-nonstyle delete" data-toggle="tooltip" title="Удалить">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
        @if(count($menuItem['child']) > 0)
            @foreach($menuItem['child'] as $menuItem)
            <ol class="dd-list">
                @include('AdminLTE.menu._listMenuItem', $menuItem)
            
            </ol>
        @endforeach
        @endif
</li>