{{--<header class="main-header">--}}

<!-- Header Navbar: style can be found in header.less -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
    </ul>
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <ul class="navbar-nav ml-auto">

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i style="font-size: 18px; color: #fff" class="fa fa-user"></i>
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <i style="font-size: 34px; color: #ffff" class="fa fa-user"></i>

                    <p>
                        {{ Auth::user()->name }}
                        {{--<small>Member since Nov. 2012</small>--}}
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="{{route('user.profile')}}" class="btn btn-default btn-flat">Профиль</a>
                    </div>
                    <div class="pull-right">
                        <a href="{{route('user.logout')}}" class="btn btn-default btn-flat">Выйти</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
    </ul>

</nav>
{{--</header>--}}