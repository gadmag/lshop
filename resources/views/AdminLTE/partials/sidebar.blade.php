<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <i style="font-size: 18px; color: #fff" class="fa fa-user"></i>
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Навигация</li>
            <li class="active">
                <a href="/admin">
                    <i class="fa fa-dashboard"></i>
                    <span>Консоль</span>

                </a>

            </li>
            <li class="header"><strong>Контент</strong></li>
            <li><a href="{{url('admin/menus?menu_type=main_menu')}}"><i class="fa fa-list-ul"></i>Главное меню</a></li>
            <li>
                <a href="{{url('admin/blocks')}}"><i class="fa fa-th"></i> <span>Блоки</span></a>
            </li>
            <li class="treeview">
                <a href="{{url('admin/pages')}}"><i class="fa fa-clone"></i> <span>Страницы</span></a>
            </li>
            <li><a href="{{url('admin/articles/photo/all')}}"><i class="fa fa-photo"></i> <span>Фотогалерея</span></a>
            </li>
            <li><a href="{{url('admin/articles/design/all')}}"><i class="fa fa-photo"></i>
                    <span>Дизайнерские идеи</span></a></li>
            <li class="header"><strong>Интернет магазин</strong></li>
            <li class="treeview"><a href="{{url('admin/catalogs')}}"><i class="fa fa-tags" aria-hidden="true"></i>
                    <span>Каталог</span></a></li>
            {{--<li class="treeview"><a href="{{url('admin/articles/news/all')}}"><i class="fa fa-newspaper-o"></i> Новости</a></li>--}}

            <li class="treeview"><a href="{{route('products.index')}}"><i class="fa fa-shopping-basket"
                                                                          aria-hidden="true"></i>
                    <span>Продукты</span></a></li>
            <li class="treeview"><a href="{{route('services.index')}}"><i class="fa fa-shopping-basket"
                                                                          aria-hidden="true"></i>
                    <span>Услуги</span></a></li>
            <li>
            <li><a href="{{url('admin/orders')}}"><i class="fa fa-shopping-cart"></i> <span>Заказы</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-list-ul" aria-hidden="true"></i><span>Справочники</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/coupons')}}"><i class="fa fa-tags"></i> <span>Купоны</span></a></li>
                    <li class="treeview">
                        <a href="{{route('fieldOptions.index')}}">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Параметры опций товара</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="header"><strong>Пользователи</strong></li>
            <li><a href="{{url('admin/users')}}"><i class="fa fa-user"></i> <span>Пользователи</span></a></li>
            {{--<li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>--}}
            {{--<li class="header">LABELS</li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>