<header>
    <div class="header-top bg-light">
        <div class="container">
            <div class="row">
                <div class="col-8 col-xs-6 col-sm-8">
                    <div class="justify-content-first social-top">
                        <div class=""><a href="#"><i class="fab fa-facebook"></i></a></div>
                        <div class=""><a href="#"><i class="fab fa-twitter"></i></a></div>
                        <div class=""><a href="#"><i class="fab fa-youtube"></i></a></div>
                        <div class=""><a target="_blank" href="http://instagram.com/Lotus_furnitura"><i class="fab fa-instagram"></i></a></div>
                        <div class="mail "><a href="mailto:lotus_furnitura@mail.ru"><i class="fal fa-enveloper"></i> lotus_furnitura@mail.ru</a></div>
                    </div>
                </div>
                <div class="col-4 col-xs-6 col-sm-4">
                    <div class="auth-link text-right">
                        <a class="btn btn-sm btn-outline-secondary " href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i>  Войти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row py-4 header-bottom">
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <ul class="list-info nav">
                        <li class="phone"><i class="fas fa-phone fa-flip-horizontal"></i> <a class="text-muted" href="tel:89882210333">8 (988) 221 03 33</a></li>
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