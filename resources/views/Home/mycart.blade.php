@extends('Home.layout')

@section('title', 'Your Cart | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Shopping Bag</div>
                    <h1 class="section-title">Review your selected pieces</h1>
                    <p class="section-copy">Update quantities, remove items, and continue to payment with delivery details captured in the same flow.</p>
                </div>
            </div>

            @if($cart->isEmpty())
                <div class="empty-state reveal">
                    <h2 class="section-title" style="font-size: 34px;">Your bag is empty</h2>
                    <p class="section-copy" style="margin-left: auto; margin-right: auto;">The catalog is ready whenever you want to start building a new order.</p>
                    <a href="{{ route('shop.index') }}" class="solid-btn" style="margin-top: 20px;">Shop Now</a>
                </div>
            @else
                <div class="cart-layout">
                    <div class="stack-lg">
                        @foreach($cart as $item)
                            <article class="cart-item reveal">
                                <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                                <div>
                                    <div class="pill">{{ $item->product->category ?? 'Collection' }}</div>
                                    <h3 style="font-family: var(--serif); font-size: 28px; margin-top: 16px;">{{ $item->product->title }}</h3>
                                    <p class="section-copy" style="margin-top: 8px;">Unit price: Rs. {{ number_format((float) $item->product->price, 2) }}</p>

                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-form">
                                        @csrf
                                        <input type="number" name="quantity" min="1" value="{{ $item->quantity }}">
                                        <button type="submit" class="text-btn">Update Qty</button>
                                        <a href="{{ url('remove_cart', $item->id) }}" class="outline-btn">Remove</a>
                                    </form>
                                </div>
                                <div>
                                    <div class="muted">Line Total</div>
                                    <div class="price-main" style="margin-top: 12px;">Rs. {{ number_format((float) $item->product->price * $item->quantity, 2) }}</div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <aside class="panel reveal delay-1">
                        <div class="eyebrow">Checkout Details</div>
                        <h2 class="section-title" style="font-size: 34px;">Order summary</h2>

                        <div class="stack-md" style="margin-top: 22px;">
                            <div class="summary-row"><span class="muted">Items</span><strong>{{ $count }}</strong></div>
                            <div class="summary-row"><span class="muted">Subtotal</span><strong>Rs. {{ number_format($subtotal, 2) }}</strong></div>
                            <div class="summary-row"><span class="muted">Shipping</span><strong>Free</strong></div>
                            <div class="summary-row" style="padding-top: 12px; border-top: 1px solid var(--border);"><span>Total</span><strong class="price-main" style="font-size: 30px;">Rs. {{ number_format($subtotal, 2) }}</strong></div>
                        </div>

                        <form action="{{ url('payment_page') }}" method="POST" class="stack-md" style="margin-top: 28px;">
                            @csrf
                            <input class="input-field" type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Full Name" required>
                            <textarea class="textarea-field" name="address" rows="4" placeholder="Address" required>{{ Auth::user()->address }}</textarea>
                            <input class="input-field" type="text" name="landmark" placeholder="Landmark (optional)">
                            <div class="grid-2">
                                <input class="input-field" type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Phone" required>
                                <input class="input-field" type="text" name="pin" placeholder="PIN Code" required>
                            </div>
                            <div class="grid-2">
                                <input class="input-field" type="text" name="city" placeholder="City" required>
                                <input class="input-field" type="text" name="state" placeholder="State" required>
                            </div>
                            <input class="input-field" type="text" name="country" value="India" placeholder="Country" required>
                            <button type="submit" class="solid-btn" style="width: 100%;">Continue to Payment</button>
                        </form>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
