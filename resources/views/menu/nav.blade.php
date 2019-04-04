<ul class="navbar-nav nav-main">

@foreach($mainMenu as $menu)
        @include('menu.menu_item', $menu)
@endforeach
</ul>


