@extends('Home.layout')

@section('title', $data->title . ' | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="detail-layout">
                <div class="detail-image reveal">
                    <img src="{{ asset('products/' . $data->image) }}" alt="{{ $data->title }}">
                </div>

                <article class="panel reveal delay-1">
                    <div class="eyebrow">{{ $data->category ?? 'Collection' }}</div>
                    <h1 class="section-title">{{ $data->title }}</h1>
                    <p class="section-copy">{{ $data->description }}</p>

                    <div class="grid-2" style="margin-top: 28px;">
                        <div class="summary-box">
                            <div class="muted">Selling Price</div>
                            <div class="price-main" style="margin-top: 10px;">Rs. {{ number_format((float) $data->price, 2) }}</div>
                        </div>
                        <div class="summary-box">
                            <div class="muted">Stock Status</div>
                            <div class="price-main" style="margin-top: 10px;">{{ max((int) $data->quantity, 0) }}</div>
                        </div>
                    </div>

                    <div class="stack-md" style="margin-top: 28px;">
                        <div class="mini-card">
                            <strong style="font-size: 20px;">Tailored buying flow</strong>
                            <p class="muted">Add this product to cart, update quantity, and continue directly into payment selection.</p>
                        </div>
                        <div class="mini-card">
                            <strong style="font-size: 20px;">Status-aware orders</strong>
                            <p class="muted">Completed orders remain connected to payment state and delivery tracking in your account.</p>
                        </div>
                    </div>

                    <div class="product-actions" style="margin-top: 28px;">
                        <a href="{{ url('add_cart', $data->id) }}" class="solid-btn">Add to Cart</a>
                        <a href="{{ url('mycart') }}" class="outline-btn">Go to Cart</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @if($similarProducts->count())
        <section class="section-tight">
            <div class="page-container">
                <div class="section-header reveal">
                    <div>
                        <div class="eyebrow">Similar Picks</div>
                        <h2 class="section-title">More from this category</h2>
                    </div>
                </div>

                <div class="grid-4">
                    @foreach($similarProducts as $index => $product)
                        <article class="product-card reveal delay-{{ $index % 4 }}">
                            <div class="product-media">
                                <div class="product-badge">{{ $product->category ?? 'Featured' }}</div>
                                <div class="product-stock">{{ (int) $product->quantity > 0 ? $product->quantity . ' left' : 'Sold out' }}</div>
                                <div class="product-quick-actions">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-quick-btn" aria-label="View {{ $product->title }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ url('add_cart', $product->id) }}" class="product-quick-btn" aria-label="Add {{ $product->title }} to cart">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->title }}">
                            </div>
                            <div class="product-body">
                                <div class="product-topline">
                                    <span class="category">{{ $product->category }}</span>
                                </div>
                                <div class="product-title">{{ $product->title }}</div>
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 78) }}</p>
                                <div class="price-row" style="margin-top: 16px;">
                                    <span class="price-main">Rs. {{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <div class="product-buttons">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-btn view">View</a>
                                    <a href="{{ url('add_cart', $product->id) }}" class="product-btn cart">Add</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
