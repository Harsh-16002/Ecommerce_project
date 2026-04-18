@extends('Home.layout')

@section('title', 'MarketVerse | Shop')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Shop Collection</div>
                    <h1 class="section-title">Browse the full catalog</h1>
                    <p class="section-copy">Filter by category, search by keyword, and sort your live products without leaving the new premium storefront.</p>
                </div>
                @auth
                    <a href="{{ url('mycart') }}" class="solid-btn">Open Cart</a>
                @else
                    <a href="{{ route('login') }}" class="solid-btn">Login to Use Cart</a>
                @endauth
            </div>

            <form action="{{ route('shop.index') }}" method="GET" class="grid-4 reveal" style="grid-template-columns: 1.4fr 1fr 1fr auto; margin-bottom: 28px;">
                <input class="input-field" type="text" name="search" value="{{ $searchTerm }}" placeholder="Search products">
                <select class="select-field" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['name'] }}" @selected($selectedCategory === $category['name'])>{{ $category['name'] }}</option>
                    @endforeach
                </select>
                <select class="select-field" name="sort">
                    <option value="latest" @selected($selectedSort === 'latest')>Newest First</option>
                    <option value="price_low" @selected($selectedSort === 'price_low')>Price Low to High</option>
                    <option value="price_high" @selected($selectedSort === 'price_high')>Price High to Low</option>
                    <option value="stock" @selected($selectedSort === 'stock')>Highest Stock</option>
                </select>
                <button type="submit" class="solid-btn">Apply</button>
            </form>

            @if($data->count())
                <div class="grid-4">
                    @foreach($data as $index => $product)
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
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 84) }}</p>
                                <div class="price-row" style="margin-top: 18px;">
                                    <span class="price-main">Rs. {{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <div class="product-buttons">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-btn view">View</a>
                                    <a href="{{ auth()->check() ? url('add_cart', $product->id) : route('login') }}" class="product-btn cart">{{ auth()->check() ? 'Add' : 'Login for Cart' }}</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pagination-wrap" style="margin-top: 34px;">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="empty-state reveal">
                    <h2 class="section-title" style="font-size: 34px;">No products matched this filter</h2>
                    <p class="section-copy" style="margin-left: auto; margin-right: auto;">Try clearing the category, changing sort, or using a broader search term.</p>
                    <a href="{{ route('shop.index') }}" class="solid-btn" style="margin-top: 20px;">Reset Catalog</a>
                </div>
            @endif
        </div>
    </section>
@endsection
