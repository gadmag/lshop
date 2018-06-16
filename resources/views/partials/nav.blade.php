{{--<ul class="">--}}
{{--<li><a href="#">Link</a></li>--}}
{{--<li class="dropdown">--}}
{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
{{--<ul class="dropdown-menu">--}}
{{--<li><a href="#">Action</a></li>--}}
{{--<li><a href="#">Another action</a></li>--}}
{{--<li><a href="#">Something else here</a></li>--}}
{{--<li role="separator" class="divider"></li>--}}
{{--<li><a href="#">Separated link</a></li>--}}
{{--</ul>--}}
{{--</li>--}}
{{--</ul>--}}
<ul class="nav navbar-nav">
    @foreach($mainMenu as $menu)
        <li>
            <a href="/@if($menu->menu_linktable_type == 'App\Page')pages/@endif{{$menu->link_path}}">{{$menu->link_title}}</a>
        </li>
    @endforeach
</ul>

