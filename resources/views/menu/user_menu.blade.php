<ul class="nav justify-content-end nav-user {{$class}}">
    <li class="nav-item dropdown">
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            @if(Auth::check())
                <a class="dropdown-item" href="{{route('user.profile')}}">Профиль пользователя</a>
                <a class="dropdown-item" href="{{route('user.logout')}}">Выйти</a>
            @else
                <a class="dropdown-item" href="{{route('login')}}">Войти</a>
                <a class="dropdown-item" href="{{route('register')}}">Регистрация</a>
            @endif
        </div>
    </li>
    <li id="cartDetailBlock" class="nav-item cart-item-detail dropdown">
        <a class=""  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="{{route('product.shoppingCart')}}">
            <i class="fal fa-shopping-basket"></i><cart-count :cartcount="itemCount"></cart-count>
        </a>
        <div class="cart-block dropdown-menu dropdown-menu-right"  aria-labelledby="cartDetailBlock">
            <cart-detail :cart="cart" :carttotal="itemCount"></cart-detail>
        </div>
    </li>
    <li class="nav-item">
        <a class="" href="{{route('product.WishList')}}"><i class="fal fa-heart"></i></a>
        <wish-count :wishcount="wishListCount"></wish-count>
    </li>


</ul>