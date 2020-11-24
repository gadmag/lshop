<li class="dd-item" data-id="{{$menuItem['id']}}">
    <div class="dd-handle">
        <span class="drag-indicator"></span>
{{--        {{$menuItem}}--}}
        <div class="title">{{$menuItem['title'] }}</div>
            <div class="btn-group ml-auto">
                <!-- edit menu item  -->
                <a  href="{{action('Admin\MenuController@edit',[$menuItem['id']])}}" class="btn btn-sm btn-default edit" title="Редактировать"
                   data-toggle="tooltip">
                    <i class="fa fa-edit"></i>
                </a>
                <!-- delete menu item -->
                <form action="{{ action('Admin\MenuController@destroy', $menuItem['id'] ) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}

                    <button type="submit" class="btn btn-sm btn-default delete" data-toggle="tooltip" title="Удалить">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
    </div>
    @if(count($menuItem['children']) > 0)
        @foreach($menuItem['children'] as $menuItem)
            <ol class="dd-list">
                @include('AdminLTE.menu._listMenuItem', $menuItem)

            </ol>
        @endforeach
        @endif
</li>