<ul class="nav justify-content-end nav-user {{$class}}">
{{--    <li class="dropdown"><a class="" data-toggle="dropdown" href="#"><img--}}
{{--                    src="{{asset('img/search.png')}}" alt=""></a>--}}
{{--        <div class="search-block dropdown-menu">--}}
{{--            @include('menu._search')--}}
{{--        </div>--}}
{{--    </li>--}}
    <li class="nav-item dropdown">
{{--        <a href="#" id="userDropdown" class="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
{{--            <img src="{{asset('img/user.png')}}" alt="">--}}
{{--            <i class="fal fa-user"></i>--}}
{{--        </a>--}}
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
{{--            <img src="{{asset('img/shopping-basket_small.png')}}" alt="Корзина">--}}
            <i class="fal fa-shopping-basket"></i><cart-count :cartcount="itemCount"></cart-count>
        </a>
        <div class="cart-block dropdown-menu dropdown-menu-right"  aria-labelledby="cartDetailBlock">
            <cart-detail :cart="cart" :carttotal="itemCount"></cart-detail>
        </div>
    </li>
    <li class="nav-item">
{{--        <img src="{{asset('img/like.png')}}" alt="">--}}
        <a class="" href="{{route('product.WishList')}}"><i class="fal fa-heart"></i></a>
        <wish-count :wishcount="wishListCount"></wish-count>
    </li>


</ul>