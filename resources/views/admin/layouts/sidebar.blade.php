<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">بابک میرحسینی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.') }}" class="nav-link {{ isActive('admin.') }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                پنل مدیریت
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ isActive(['admin.users.index','admin.users.create','admin.users.edit'] , 'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit'] , 'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                بخش اجازه دسترسی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>دسترسی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مقام ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ isActive(['admin.orders.index','admin.orders.create','admin.orders.edit'] , 'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.orders.index','admin.orders.create','admin.orders.edit']) }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                بخش سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
{{--                            <a href="{{ route('admin.orders.index') }}?search=paid" class="nav-link {{ isUrl('paid') }}">--}}
                                <a href="{{ route('admin.orders.index' , ['type' => 'paid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'paid'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-success"></i>
                                    <p>پرداخت شده
                                        <span class="badge badge-info right">{{ \App\Models\Order::whereStatus('paid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
{{--                            <a href="{{ route('admin.orders.index') }}?search=unpaid" class="nav-link {{ isUrl('unpaid') }}">--}}
                                <a href="{{ route('admin.orders.index' , ['type' => 'unpaid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'unpaid'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-warning"></i>
                                    <p>پرداخت نشده
                                        <span class="badge badge-info right">{{ \App\Models\Order::whereStatus('unpaid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
{{--                            <a href="{{ route('admin.orders.index') }}?search=canceled" class="nav-link {{ isUrl('canceled') }}">--}}
                                <a href="{{ route('admin.orders.index' , ['type' => 'canceled']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'canceled'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-danger"></i>
                                    <p>کنسل شده
                                        <span class="badge badge-info right">{{ \App\Models\Order::whereStatus('canceled')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
