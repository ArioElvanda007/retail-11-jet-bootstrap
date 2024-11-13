        @inject('provider', 'App\Http\Controllers\Function\GlobalController')

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('logo.ico') }}" alt="{{ config('app.description', 'Retail-ERP3') }} Logo"
                    class="brand-image img-circle elevation-0" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Retail-ERP3') }}</span>
                @if (env('APP_DEBUG') == 1) <span class="badge badge-danger ml-1">Debug</span> @endif
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @can('manage dashboard')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'dashboard' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}"
                                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-th"></i>
                                            <p>
                                                Dashboard
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage stock')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'products' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('stock.products.index') }}"
                                            class="nav-link {{ request()->routeIs('stock.products.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-cube"></i>
                                            <p>
                                                Products
                                            </p>
                                        </a>
                                    </li>  
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage selling')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'customers' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('selling.customers.index') }}"
                                            class="nav-link {{ request()->routeIs('selling.customers.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-users"></i>
                                            <p>
                                                Customers
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage buying')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'suppliers' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('buying.suppliers.index') }}"
                                            class="nav-link {{ request()->routeIs('buying.suppliers.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user-md"></i>
                                            <p>
                                                Suppliers
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage accounting')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'accounts' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('accounting.accounts.index') }}"
                                            class="nav-link {{ request()->routeIs('accounting.accounts.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-list"></i>
                                            <p>
                                                Accounts
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                            
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'banks' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('accounting.banks.index') }}"
                                            class="nav-link {{ request()->routeIs('accounting.banks.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-university"></i>
                                            <p>
                                                Banks
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage buying')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'buying' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('buying.buying.index') }}"
                                            class="nav-link {{ request()->routeIs('buying.buying.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-shopping-cart"></i>
                                            <p>
                                                Buying
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan

                        @can('manage selling')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'selling' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('selling.selling.index') }}"
                                            class="nav-link {{ request()->routeIs('selling.selling.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-coffee"></i>
                                            <p>
                                                Selling
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan                        

                        @can('manage stock')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'adjustment' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('stock.stocks.index') }}"
                                            class="nav-link {{ request()->routeIs('stock.stocks.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-cubes"></i>
                                            <p>
                                                Adjustment
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan    

                        @can('manage accounting')
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'cashflows' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('accounting.cashflows.index') }}"
                                            class="nav-link {{ request()->routeIs('accounting.cashflows.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-eur"></i>
                                            <p>
                                                Cashflows
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan    







                        @can('manage report')
                            <li class="nav-header">REPORT</li>
                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report cashflows' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.stocks.index') }}"
                                            class="nav-link {{ request()->routeIs('report.stocks.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Stocks
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report buying' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.buying.index') }}"
                                            class="nav-link {{ request()->routeIs('report.buying.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Buying
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report selling' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.selling.index') }}"
                                            class="nav-link {{ request()->routeIs('report.selling.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Selling
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report cashflows' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.cashflows.index') }}"
                                            class="nav-link {{ request()->routeIs('report.cashflows.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Cashflows
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report accounting' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.accounting.index') }}"
                                            class="nav-link {{ request()->routeIs('report.accounting.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Balance
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'report ledger' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('report.ledger.index') }}"
                                            class="nav-link {{ request()->routeIs('report.ledger.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Ledger
                                            </p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endcan  






                        {{-- @can('manage content')
                            <li class="nav-header">CONTENT</li>
                            <li class="nav-item">
                                <a href="{{ route('content.home.headlines.index') }}"
                                    class="nav-link {{ request()->routeIs('content.home.headlines.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Headlines
                                    </p>
                                </a>
                            </li>
                        @endcan   --}}







                        @role('admin')
                            <li class="nav-header">ADMIN</li>

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'users' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>Users</p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'roles' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-graduation-cap"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'permissions' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.permissions.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-check-square"></i>
                                            <p>Permissions</p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'modules' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.modules.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-folder-open"></i>
                                            <p>Menus</p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach

                            @foreach ($provider::access()->access as $data)
                                @if ($data->modules->name == 'business' && $data->modules->is_active == 1 && $data->can_view == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.business.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.business.*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-building"></i>
                                            <p>Business</p>
                                        </a>
                                    </li>
                                    @break
                                @endif
                            @endforeach
                        @endrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
