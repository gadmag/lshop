<li class="nav-item {{(count($menu->children) > 0)? 'dropdown': ''}} {{$loop->first?'first':''}} {{$loop->last?'last':''}}"
    data-depth="{{$menu['depth']}}">

    @if(count($menu->children) > 0)
        @if($menu->path == '<nolink>')
            <span class="nolink {{$menu->class?:''}}">{{$menu->title}}</span>
        @else
            <a class="nav-link {{$menu->class?:''}}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
               href="{{$menu->link_path}}">{{$menu->title}}</a>
        @endif
    @else
        @if($menu->path == '<nolink>')
            <span class="nolink {{$menu->class?:''}}">{{$menu->title}}</span>
        @else
            <a class="nav-link {{$menu->class?:''}} @if($menu->parent_id > 0){{'dropdown-item'}}@endif"
               href="{{$menu->link_path}}">{{$menu->title}}</a>
        @endif
    @endif
    @if(count($menu->children) > 0)
        <ul class="dropdown-menu">
            @foreach($menu->children as $menu)
                @include('menu.menu_item', $menu)
            @endforeach
        </ul>

    @endif
</li>
