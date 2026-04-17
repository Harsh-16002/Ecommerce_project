<header class="site-header" id="siteHeader">
    <div class="page-container">
        <div class="nav-row">
            <a href="{{ url('/') }}" class="brand-mark">
                <img src="{{ asset('images/marketverse-mark.svg') }}" alt="MarketVerse logo" class="brand-logo-icon">
                <span class="brand-wordmark">Market<span>Verse</span></span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'is-active' : '' }}">Home</a></li>
                <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.index') ? 'is-active' : '' }}">Shop</a></li>
                <li><a href="{{ route('why.index') }}" class="{{ request()->routeIs('why.index') ? 'is-active' : '' }}">Why Us</a></li>
                <li><a href="{{ route('testimonial.index') }}" class="{{ request()->routeIs('testimonial.index') ? 'is-active' : '' }}">Reviews</a></li>
                <li><a href="{{ route('contact-us.index') }}" class="{{ request()->routeIs('contact-us.index') ? 'is-active' : '' }}">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <button type="button" class="icon-btn desktop-only" id="searchToggle" title="Search">/</button>

                @auth
                    <a href="{{ url('myorders') }}" class="icon-btn desktop-only" title="Orders">O</a>
                    <a href="{{ url('mycart') }}" class="icon-btn" title="Cart">
                        C
                        <span class="count-badge">{{ $count ?? 0 }}</span>
                    </a>

                    @if(($storefrontAdminShortcuts ?? collect())->isNotEmpty())
                        <a href="{{ route('admin.dashboard') }}" class="text-btn desktop-only">Admin</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="desktop-only">
                        @csrf
                        <button type="submit" class="text-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-btn desktop-only">Login</a>
                    <a href="{{ route('register') }}" class="solid-btn desktop-only">Sign Up</a>
                @endauth

                <button type="button" class="icon-btn menu-toggle" id="menuToggle" title="Menu">=</button>
            </div>
        </div>

        <div class="search-panel" id="searchPanel">
            <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                <input
                    id="globalSearchField"
                    class="search-field"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search for products, categories, or collections">
                <button type="submit" class="solid-btn">Search</button>
            </form>
        </div>
    </div>
</header>

<div class="mobile-overlay" id="mobileOverlay"></div>
<aside class="mobile-drawer" id="mobileDrawer">
    <button type="button" class="mobile-close" id="mobileClose">&times;</button>
    <a href="{{ url('/') }}" class="brand-mark">
        <img src="{{ asset('images/marketverse-mark.svg') }}" alt="MarketVerse logo" class="brand-logo-icon">
        <span class="brand-wordmark">Market<span>Verse</span></span>
    </a>

    <ul class="mobile-links">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('shop.index') }}">Shop</a></li>
        <li><a href="{{ route('why.index') }}">Why Us</a></li>
        <li><a href="{{ route('testimonial.index') }}">Reviews</a></li>
        <li><a href="{{ route('contact-us.index') }}">Contact</a></li>
        @auth
            <li><a href="{{ url('mycart') }}">Cart</a></li>
            <li><a href="{{ url('myorders') }}">Orders</a></li>
        @endauth
    </ul>

    <div class="mobile-cta">
        <form action="{{ route('shop.index') }}" method="GET">
            <input class="search-field" type="text" name="search" value="{{ request('search') }}" placeholder="Search the store">
        </form>

        @auth
            @if(($storefrontAdminShortcuts ?? collect())->isNotEmpty())
                <div class="mobile-links" style="margin-top: 0;">
                    @foreach($storefrontAdminShortcuts as $shortcut)
                        <a href="{{ $shortcut['url'] }}">{{ $shortcut['label'] }}</a>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="solid-btn" style="width: 100%;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-btn">Login</a>
            <a href="{{ route('register') }}" class="solid-btn">Create Account</a>
        @endauth
    </div>
</aside>
