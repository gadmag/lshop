<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{asset('AdminLTE/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="sidebar">
        <!-- Sidebar user panel -->

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"><img src="{{asset('AdminLTE/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info"><a href="#" class="d-block">{{ Auth::user()->name }}</a></div>
        </div>


        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Навигация</p>
                    </a>
                <li class="nav-header">Интернет магазин</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="{{url('admin/catalogs')}}"><i class="nav-icon fa fa-tags" aria-hidden="true"></i>
                        <p>Каталог</p></a>
                </li>

                <li class="nav-item has-treeview"><a class="nav-link" href="{{route('products.index')}}">
                        <i class="nav-icon fa fa-shopping-basket" aria-hidden="true"></i><p>Продукты</p></a></li>
                <li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/orders')}}"><i class="nav-icon fa fa-shopping-cart"></i>
                        <p>Заказы
                            @if($countNewOrder)
                            <span class="badge badge-info right">{{$countNewOrder}}</span>
                            @endif
                        </p></a></li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#"><i class="nav-icon fa fa-list-ul" aria-hidden="true"></i><p>Справочники</p>
                        <i class="nav-icon fa fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a class="nav-link" href="{{url('admin/coupons')}}"><i class="nav-icon fa fa-tags"></i>
                                <p>Купоны</p></a></li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('fieldOptions.index')}}">
                                <i class="nav-icon fa fa-shopping-basket" aria-hidden="true"></i><p>Параметры опций товара</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('services.index')}}">
                                <i class="nav-icon fa fa-shopping-basket" aria-hidden="true"></i><p>Услуга товара</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('orderStatus.index')}}">
                                <i class="nav-icon far fa-circle" aria-hidden="true"></i><p>Статусы заказа</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('shipments.index')}}">
                                <i class="far fa-circle nav-icon" aria-hidden="true"></i><p>Способы доставки</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('payments.index')}}">
                                <i class="nav-icon far fa-circle" aria-hidden="true"></i><p>Способы оплаты</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Контент</li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/menus?menu_type=main_menu')}}"><i class="nav-icon fa fa-list-ul"></i>Главное меню</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/blocks')}}"><i class="nav-icon fa fa-th"></i> <p>Блоки</p></a>
                </li>
                <li class="nav-item  has-treeview">
                    <a class="nav-link" href="{{url('admin/pages')}}"><i class="nav-icon fa fa-clone"></i> <p>Страницы</p></a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/articles/photo/all')}}"><i class="nav-icon fa fa-images"></i> <p>Фотогалерея</p></a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/articles/design/all')}}"><i class="nav-icon fa fa-image"></i>
                        <p>Дизайнерские идеи</p></a></li>

                <li class="nav-header">Система</li>
                <li class="nav-item"><a class="nav-link" href="{{route('settings')}}"><i class="nav-icon fa fa-cogs"></i>
                        <p>Настройки</p></a></li>
                @role('admin')
                <li class="nav-item"><a class="nav-link" href="{{url('admin/users')}}"><i class="nav-icon fa fa-user"></i> <p>Пользователи</p></a></li>
                @endrole

            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>