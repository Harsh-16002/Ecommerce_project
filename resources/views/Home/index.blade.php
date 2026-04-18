@extends('Home.layout')

@section('title', 'MarketVerse | Discover What Moves Your Day')

@section('content')
    <section>
        <div class="page-container hero-grid">
            <div class="hero-copy reveal">
                <div class="eyebrow">Marketplace Edition 2026</div>
                <h1 class="hero-title">Everything your day needs in one <em>smarter</em> marketplace.</h1>
                <p>
                    Explore electronics, fashion, beauty, office, gaming, and home essentials in one polished storefront.
                    Browse faster, compare across categories, and move from discovery to checkout without friction.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('shop.index') }}" class="solid-btn">Shop Now</a>
                    <a href="#featured-products" class="outline-btn">View Highlights</a>
                </div>
                <div class="stats-row">
                    <div class="stat-item">
                        <strong>{{ number_format($stats['active_customers']) }}+</strong>
                        <span>Active Customers</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ number_format($stats['products']) }}+</strong>
                        <span>Products Live</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ number_format($stats['orders']) }}+</strong>
                        <span>Orders Served</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual reveal delay-1">
                <img src="{{ asset('images/marketverse-hero.svg') }}" alt="MarketVerse marketplace hero">
                <div class="floating-card">
                    <span>Featured Pick</span>
                    <strong>{{ $heroProduct?->title ?? 'Signature Edit' }}</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="section-tight">
        <div class="page-container">
            <div class="feature-list reveal">
                <div class="feature-item">
                    <div class="value-lg">01</div>
                    <strong>Free Shipping</strong>
                    <p>Orders above Rs. 2,499 ship free, making every marketplace checkout feel simpler.</p>
                </div>
                <div class="feature-item">
                    <div class="value-lg">02</div>
                    <strong>Smart Cart</strong>
                    <p>Stock-aware cart and quantity validation continue straight into payment selection.</p>
                </div>
                <div class="feature-item">
                    <div class="value-lg">03</div>
                    <strong>Flexible Payment</strong>
                    <p>Choose cash on delivery or PayPal while keeping delivery details attached to each order.</p>
                </div>
                <div class="feature-item">
                    <div class="value-lg">04</div>
                    <strong>Order Tracking</strong>
                    <p>Customers can review payment state, totals, and delivery status in one place.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Shop by Category</div>
                    <h2 class="section-title">Categories built for real-world shopping habits</h2>
                    <p class="section-copy">Each collection leads into your live catalog, making the homepage feel like a true multi-category marketplace.</p>
                </div>
                <a href="{{ route('shop.index') }}" class="outline-btn">View All</a>
            </div>

            <div class="grid-4">
                @foreach($categories->take(4) as $index => $category)
                    @php
                        $categoryProduct = $featuredProducts->firstWhere('category', $category['name']) ?? $featuredProducts->get($index);
                    @endphp
                    <article class="category-card reveal delay-{{ min($index, 3) }}">
                        <img src="{{ $categoryProduct ? asset('products/' . $categoryProduct->image) : asset('images/marketverse-hero.svg') }}" alt="{{ $category['name'] }}">
                        <div class="card-overlay">
                            <h3>{{ $category['name'] }}</h3>
                            <p>{{ $category['product_count'] }} products in this collection</p>
                            <a href="{{ route('shop.index', ['category' => $category['name']]) }}" class="link-inline">Explore</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <div class="marquee">
        <div class="marquee-track">
            <div class="marquee-item">New Arrivals</div>
            <div class="marquee-item">Tech Essentials</div>
            <div class="marquee-item">Everyday Fashion</div>
            <div class="marquee-item">Home Upgrades</div>
            <div class="marquee-item">Gaming Setup</div>
            <div class="marquee-item">Travel Ready</div>
            <div class="marquee-item">New Arrivals</div>
            <div class="marquee-item">Tech Essentials</div>
            <div class="marquee-item">Everyday Fashion</div>
            <div class="marquee-item">Home Upgrades</div>
            <div class="marquee-item">Gaming Setup</div>
            <div class="marquee-item">Travel Ready</div>
        </div>
    </div>

    <section class="section" id="featured-products">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Trending Now</div>
                    <h2 class="section-title">Your real catalog, reintroduced as a modern marketplace</h2>
                    <p class="section-copy">These products still use your live database records and working cart links, now framed for broader category discovery.</p>
                </div>
                <a href="{{ route('shop.index') }}" class="outline-btn">Shop Catalog</a>
            </div>

                <div class="grid-4">
                    @foreach($featuredProducts->take(8) as $index => $product)
                        <article class="product-card reveal delay-{{ $index % 4 }}">
                            <div class="product-media">
                                <div class="product-badge">{{ $product->category ?? 'Featured' }}</div>
                                <div class="product-stock">{{ (int) $product->quantity > 0 ? $product->quantity . ' left' : 'Sold out' }}</div>
                                <div class="product-quick-actions">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-quick-btn" aria-label="View {{ $product->title }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ auth()->check() ? url('add_cart', $product->id) : route('login') }}" class="product-quick-btn" aria-label="{{ auth()->check() ? 'Add ' . $product->title . ' to cart' : 'Login to add ' . $product->title . ' to cart' }}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->title }}">
                            </div>
                            <div class="product-body">
                                <div class="product-topline">
                                    <span class="category">{{ $product->category ?? 'Collection' }}</span>
                                </div>
                                <div class="product-title">{{ $product->title }}</div>
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 92) }}</p>
                                <div class="price-row" style="margin-top: 18px;">
                                    <span class="price-main">Rs. {{ number_format((float) $product->price, 2) }}</span>
                                    <span class="price-old">Rs. {{ number_format((float) $product->price * 1.25, 2) }}</span>
                                </div>
                                <div class="product-buttons">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-btn view">View</a>
                                    <a href="{{ auth()->check() ? url('add_cart', $product->id) : route('login') }}" class="product-btn cart">{{ auth()->check() ? 'Add' : 'Login for Cart' }}</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
            </div>
        </div>
    </section>

    <section class="section-tight">
        <div class="page-container grid-2">
            <div class="panel panel-dark reveal">
                <div class="eyebrow">Store Snapshot</div>
                <h2 class="section-title" style="margin-top: 18px;">Marketplace feel, backend flow intact</h2>
                <p class="section-copy">This redesign keeps your Laravel product, cart, payment, and order routes active while shifting the storefront from boutique styling to a broader commerce brand.</p>
                <div class="grid-2" style="margin-top: 26px;">
                    <div class="metric-card">
                        <strong>{{ $topSellingProducts->count() }}</strong>
                        <p class="muted">Top-selling products highlighted from real order data.</p>
                    </div>
                    <div class="metric-card">
                        <strong>{{ $count }}</strong>
                        <p class="muted">Current cart item count stays wired into the shared header.</p>
                    </div>
                </div>
            </div>

            <div class="grid-2">
                @foreach($topSellingProducts->take(4) as $product)
                    <article class="mini-card reveal">
                        <span class="pill">Top Pick</span>
                        <strong style="font-size: 22px; margin-top: 16px;">{{ $product->title }}</strong>
                        <p class="muted">{{ $product->category }} | {{ (int) $product->units_sold }} sold</p>
                        <a href="{{ url('product_details', $product->id) }}" class="link-inline">Open Product</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
