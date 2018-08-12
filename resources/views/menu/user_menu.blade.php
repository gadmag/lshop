<ul class="nav {{$class}} nav-user navbar-nav navbar-right">
    <li class="cart-item-detail dropdown"><a class="dropdown-toggle" data-toggle="dropdown"
                                             href="{{route('product.shoppingCart')}}">
            <img src="{{asset('img/shopping-basket_small.png')}}" alt="Корзина">
            <cart-count :cartcount="itemCount"></cart-count>
        </a>
        <div class="cart-block dropdown-menu">
            <cart-detail :cart="cart" :carttotal="itemCount"></cart-detail>
        </div>
    </li>
    <li class="dropdown">
        <a href="{{route('product.WishList')}}"><img src="{{asset('img/like.png')}}" alt=""></a>
        <wish-count :wishcount="wishListCount"></wish-count>
    </li>
    <li class="dropdown">
        <a href="#" class="fa fa-user-o dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false"><img src="{{asset('img/user.png')}}"
                                                           alt=""></a>
        <ul class="dropdown-menu admin-dropdown">
            @if(Auth::check())
                <li><a href="{{route('user.profile')}}">Профиль пользователя</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{route('user.logout')}}">Выйти</a></li>
            @else
                <li><a href="{{route('login')}}">Войти</a></li>
                <li><a href="{{route('register')}}">Регистрация</a></li>
            @endif

        </ul>
    </li>
</ul>