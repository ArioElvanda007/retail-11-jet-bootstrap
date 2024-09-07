        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('logo.ico') }}" alt="{{ config('app.description', 'Retail-ERP3') }} Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.description', 'Retail-ERP3') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @can('manage dashboard')
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage stock')
                            <li class="nav-item">
                                <a href="{{ route('stock.products.index') }}"
                                    class="nav-link {{ request()->routeIs('stock.products.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cube"></i>
                                    <p>
                                        Products
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage selling')
                            <li class="nav-item">
                                <a href="{{ route('selling.customers.index') }}"
                                    class="nav-link {{ request()->routeIs('selling.customers.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Customers
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage buying')
                            <li class="nav-item">
                                <a href="{{ route('buying.suppliers.index') }}"
                                    class="nav-link {{ request()->routeIs('buying.suppliers.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-md"></i>
                                    <p>
                                        Suppliers
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage accounting')
                            <li class="nav-item">
                                <a href="{{ route('accounting.banks.index') }}"
                                    class="nav-link {{ request()->routeIs('accounting.banks.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-university"></i>
                                    <p>
                                        Banks
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage buying')
                            <li class="nav-item">
                                <a href="{{ route('buying.buying.index') }}"
                                    class="nav-link {{ request()->routeIs('buying.buying.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Buying
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('manage selling')
                            <li class="nav-item">
                                <a href="{{ route('selling.selling.index') }}"
                                    class="nav-link {{ request()->routeIs('selling.selling.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-coffee"></i>
                                    <p>
                                        Selling
                                    </p>
                                </a>
                            </li>
                        @endcan                        

                        @can('manage stock')
                            <li class="nav-item">
                                <a href="{{ route('stock.stocks.index') }}"
                                    class="nav-link {{ request()->routeIs('stock.stocks.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cubes"></i>
                                    <p>
                                        Adjustment
                                    </p>
                                </a>
                            </li>
                        @endcan    

                        @can('manage accounting')
                            <li class="nav-item">
                                <a href="{{ route('accounting.cashflows.index') }}"
                                    class="nav-link {{ request()->routeIs('accounting.cashflows.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-eur"></i>
                                    <p>
                                        Cashflows
                                    </p>
                                </a>
                            </li>
                        @endcan    




                        @role('admin')
                            <li class="nav-header">ADMIN</li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Users</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>Roles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.business.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.business.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Business</p>
                                </a>
                            </li>
                        @endrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
