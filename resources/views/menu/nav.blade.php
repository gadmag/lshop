<ul class="nav navbar-nav">

@foreach($mainMenu as $menu)
        @include('menu.menu_item', $menu)
@endforeach
</ul>


