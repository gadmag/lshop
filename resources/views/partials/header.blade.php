<header>
    <div class="container">
{{--        d-none d-md-block--}}
        <div class="mb-2  header-top">
            <div class="row">
                <div class="logo-block col-sm-6 col-md-4 col-lg-3">
                    <div class="text-left">
                        <a href="/" class="logo"><img class="img-fluid" src="{{asset('img/logo_new.jpg')}}" alt=""></a>
                    </div>
                </div>
                <div class="info-header col-sm-6 col-md-4 col-lg-6">
                    <ul class="list-info nav my-2 justify-content-end">
                        <li class="phone"><span class="fa fa-phone"></span> <a href="tel:89882210333"> 8 (988) 221 03 33</a></li>
                        <li class="mail"><span class="fa fa-envelope-o"></span> <a href="mailto:lotus_furnitura@mail.ru">lotus_furnitura@mail.ru</a></li>
                    </ul>
                </div>
                <div class="block-right d-none d-md-block col-sm-4 col-md-4 col-lg-3">
                    <div class="clearfix">
                        @include('menu.user_menu', ['class' => 'myClass'])
                    </div>
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
        </div>
        @include('menu.user_menu', ['class' => 'hidden-menu justify-content-end'])
    <div class="clearfix"></div>
</nav>