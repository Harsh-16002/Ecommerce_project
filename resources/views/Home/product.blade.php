<section class="store-panel p-4 p-lg-5">
  <div class="store-section-head">
    <div>
      <span class="store-chip">Featured catalog</span>
      <h2 class="mt-3 mb-2">Fresh arrivals across the store</h2>
      <p class="mb-0">A sharper product grid with quick access to details, cart, and live stock context.</p>
    </div>

    <a href="{{ route('shop.index') }}" class="store-outline-btn">View Full Shop</a>
  </div>

  <div class="store-product-grid">
    @foreach($data->take(8) as $product)
      <article class="store-product-card">
        <div class="store-product-media">
          <img src="{{ asset('products/'.$product->image) }}" alt="{{ $product->title }}">
        </div>

        <div class="store-product-body">
          <div class="store-product-meta">
            <span class="store-chip">{{ $product->category ?? 'Collection' }}</span>
            <span class="store-subtle">{{ (int) $product->quantity > 0 ? $product->quantity.' in stock' : 'Sold out' }}</span>
          </div>

          <h4 class="mb-2">{{ $product->title }}</h4>
          <p class="store-subtle">{{ \Illuminate\Support\Str::limit($product->description, 95) }}</p>
          <div class="store-row-between mt-4">
            <div class="store-price">Rs. {{ number_format((float) $product->price, 2) }}</div>
          </div>

          <div class="store-product-actions mt-4">
            <a href="{{ url('product_details', $product->id) }}" class="store-outline-btn">View Details</a>
            <a href="{{ url('add_cart', $product->id) }}" class="store-solid-btn">Add to Cart</a>
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
