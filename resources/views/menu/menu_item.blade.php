<li class="@if(count($menu['child']) > 0){{'dropdown'}}@endif @if($loop->first){{'first'}}@endif @if($loop->last){{'last'}}@endif">

    @if(count($menu['child']) > 0)
       <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
           href="/@if($menu['item']['menu_linktable_type'] == 'App\Page')
                   pages/{{$menu['item']['menu_linktable_id']}}
           @elseif($menu['item']['menu_linktable_type'] == 'App\Catalog')catalogs/{{$menu['item']['menu_linktable_id']}}
           @else{{$menu['item']['link_path']}}@endif">{{$menu['item']['link_title']}}</a>
    @else
        <a href="/@if($menu['item']['menu_linktable_type'] == 'App\Page')
                pages/{{$menu['item']['menu_linktable_id']}}
        @elseif($menu['item']['menu_linktable_type'] == 'App\Catalog')catalogs/{{$menu['item']['menu_linktable_id']}}
               @else{{$menu['item']['link_path']}}@endif">{{$menu['item']['link_title']}}</a>
    @endif
    @if(count($menu['child']) > 0)
            <ul class="dropdown-menu">
                @foreach($menu['child'] as $menu)

                    @include('menu.menu_item', $menu)
                @endforeach
            </ul>

    @endif
</li>