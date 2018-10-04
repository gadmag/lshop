<header>
    <div class="container">
        <div class="row hidden-xs header-top">


            <div class="col-sm-4">
                <div class="block-search">
                    <form class="" method="get" action="/search">
                        <div class="inline-form">
                            <input type="text" class="" name="q" placeholder="Поиск"><button type="submit"><span class="fa fa-search"></span></button>
                        </div>
                    </form>

                </div>

            </div>
            <div class="col-sm-4">
                <div class="text-center logo-block">
                    <a href="/" class="logo"><img style="max-width: 250px" class="" src="{{asset('img/logo_new.jpg')}}" alt=""></a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block-right clearfix">
                    @include('menu.user_menu', ['class' => 'myClass'])
                </div>
            </div>
        </div>
    </div>

    <div id="messege"></div>
</header>

<nav class="navbar navbar-default" data-spy="affix" data-offset-top="220">

    <div style="position: relative" class="">
        <a class="navbar-brand" href="/"><img class="img-responsive" src="{{asset('img/logo.jpg')}}" alt=""></a>
        <div class="container">
            <div class="">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    @include('menu.nav')

                </div>
            </div>
        </div>
        @include('menu.user_menu', ['class' => 'hidden-menu'])
    </div>
    <div class="clearfix"></div>
    <div id="search-mobile" class="visible-xs">
        <div class="pull-right block-search">
            <form class="" method="get" action="/search">
                <div class="inline-form">
                    <input type="text" class="" name="q" placeholder="Поиск"><button type="submit"><span class="fa fa-search"></span></button>
                </div>
            </form>
        </div>
    </div>

</nav>