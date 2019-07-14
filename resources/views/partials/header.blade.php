<header>
    <div class="header-top bg-light">
        <div class="container">
            <div class="row">
                <div class="col-8 col-xs-6 col-sm-8">
                    @include('block.top_head')
                </div>
                <div class="col-4 col-xs-6 col-sm-4">
                    <div class="auth-link text-right">
                        @guest
                            <auth-modal recaptcha-key="{{config('payment.recaptcha_key')}}"></auth-modal>
                        @endguest
                        @auth
                            <div class="dropdown user-menu">
                                <button class="btn btn-link text-muted  dropdown-toggle" type="button"
                                        id="dropdownUserMenu" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    {{Auth::user()->name}}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserMenu">
                                    <a class="dropdown-item" href="{{route('user.profile')}}">Профиль</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('user.logout')}}">
                                        <i class="far fa-sign-out-alt"></i> Выход
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row py-4 header-bottom">
            <div class="col-sm-6 col-md-4 col-lg-4">
                <ul class="list-info nav">
                    <li class="phone"><i class="fas fa-phone fa-flip-horizontal"></i> <a class="text-muted"
                                                                                         href="tel:89882210333">8 (988)
                            221 03 33</a></li>
                </ul>
                <div class="search-block">
                    @include('menu._search')
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="logo-block text-center">
                    <a href="/" class="logo"><img class="img-fluid" src="{{asset('img/logo_new.jpg')}}" alt=""></a>
                </div>
            </div>
            <div class="block-right d-none d-md-block col-sm-4 col-md-4 col-lg-4">
                <div class="clearfix">
                    @include('menu.user_menu', ['class' => 'myClass'])
                </div>
            </div>
        </div>
    </div>

    <div id="messege"></div>
</header>

<nav class="navbar navbar-menu navbar-light navbar-expand-md" data-toggle="affix">
    <a class="navbar-brand" href="/"><img class="img-fluid" src="{{asset('img/logo.jpg')}}" alt=""></a>
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @include('menu.nav')
        </div>
        @include('menu.user_menu', ['class' => 'hidden-menu justify-content-end'])
    </div>

    <div class="clearfix"></div>
</nav>