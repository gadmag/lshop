<ul class="{{$class}}">
    <li class="nav-item dropdown">
        @guest
            <a href="#" class="icon icon-user" data-toggle="modal" data-target="#modal-auth">
                <i class="fal fa-user"></i>
                <span class="title">Войти</span>
            </a>
            <auth-modal recaptcha-key="{{config('payment.recaptcha_key')}}"></auth-modal>
        @endguest
        @auth
            <a href="#" class="icon icon-user"
               id="dropdownUserMenu" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <i class="fal fa-user"></i>
                <span class="title">{{Auth::user()->name}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserMenu">
                <a class="dropdown-item" href="{{route('user.profile')}}">Профиль</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('user.logout')}}">
                    <i class="far fa-sign-out-alt"></i>
                    <span class="title">Выход</span>
                </a>
            </div>
        @endauth

    </li>
    <li class="nav-item">
        <a class="icon icon-heart" href="{{route('product.WishList')}}"><i class="fal fa-heart"></i>
            <span class="title">Избранное</span>
            <wish-count :wishcount="wishListCount"></wish-count>
        </a>
    </li>
    <li id="cartDetailBlock" class="nav-item cart-item-detail dropdown">
        <a class="icon icon-baskek" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
           href="{{route('product.shoppingCart')}}">
            <i class="fal fa-shopping-basket"></i>
            <span class="title">Корзина</span>
            <cart-count :cartcount="itemCount"></cart-count>
        </a>
        <div class="cart-block dropdown-menu dropdown-menu-right" aria-labelledby="cartDetailBlock">
            <cart-detail :cart="cart" :carttotal="itemCount"></cart-detail>
        </div>
    </li>
    <li class="nav-item nav-item-menu">
        <a href="#" class="icon first-button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal animated-icon"></i>
            <span class="title">Меню</span>
        </a>
    </li>



</ul>