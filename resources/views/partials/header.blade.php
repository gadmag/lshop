<header>
    <div class="header-top">
        <div class="container">

            <div class="d-flex flex-row-reverse">
                <div>
                    @include('block.top_head')
                </div>
            </div>

        </div>
    </div>
    <div class="py-4 header-bottom" data-toggle="affix">
        <div class="container">
            <div class="row">
                <div class="logo-block col-6 col-sm-6 col-md-6 col-lg-4">
                    <a class="navbar-brand" href="{{config('app.url')}}">
                        <img class="img-fluid" src="{{asset('img/logo.jpg')}}" alt="">
                    </a>
                    <a class="logo" href="{{config('app.url')}}">
                        <img class="img-fluid" src="{{asset('img/logo_new.jpg')}}" alt="">
                    </a>
                </div>
                <div class="block-right col-6 col-sm-6  col-md-6 col-lg-4 order-lg-2 order-md-1">
                    @include('menu.user_menu', ['class' => 'nav justify-content-end nav-user'])
                </div>
                <div class="block-center col-md-12 col-lg-4 order-lg-1 order-md-2">
                    <div class="search-block">
                        @include('menu._search')
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-menu navbar-light  navbar-expand-lg">
            <div class="container">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    @include('menu.nav')
                </div>
            </div>
        </nav>
    </div>
</header>
