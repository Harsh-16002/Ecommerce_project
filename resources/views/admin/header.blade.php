<header class="admin-topbar">
    <div class="admin-topbar-inner">
        <div class="admin-topbar-heading">
            <button type="button" class="admin-menu-toggle" data-admin-sidebar-toggle aria-label="Open navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="admin-kicker">@yield('admin_kicker', 'Admin Panel')</div>
            <div class="admin-topbar-title">@yield('admin_title', 'Welcome back, Admin')</div>
            <div class="admin-topbar-subtitle">@yield('admin_subtitle', 'Manage products, orders, payments, and category structure from one place.')</div>
        </div>

        <div class="admin-search">
            <form action="{{ route('admin.products.search') }}" method="GET">
                <input type="search" name="search" placeholder="Search products, categories, or catalog text..." value="{{ $searchTerm ?? '' }}">
            </form>
        </div>

        <div class="admin-topbar-actions">
            <a href="{{ url('/') }}" class="admin-btn-outline"><i class="fa fa-external-link"></i> Storefront</a>
            <a href="{{ route('admin.settings.index') }}" class="admin-btn-outline"><i class="fa fa-cog"></i> Settings</a>
            <div class="admin-btn-outline"><i class="fa fa-bell-o"></i> {{ $adminQuickStats['orders'] }} Orders</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-btn"><i class="fa fa-sign-out"></i> Logout</button>
            </form>
        </div>
    </div>
</header>
