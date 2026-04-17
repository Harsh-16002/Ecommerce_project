@extends('Home.layout')

@section('title', 'My Orders | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Order History</div>
                    <h1 class="section-title">Track every purchase in one place</h1>
                    <p class="section-copy">See product details, payment status, transaction references, and delivery state without leaving the storefront.</p>
                </div>
            </div>

            @if($order->isEmpty())
                <div class="empty-state reveal">
                    <h2 class="section-title" style="font-size: 34px;">No orders yet</h2>
                    <p class="section-copy" style="margin-left: auto; margin-right: auto;">Once checkout is complete, your full timeline will appear here.</p>
                    <a href="{{ route('shop.index') }}" class="solid-btn" style="margin-top: 20px;">Start Shopping</a>
                </div>
            @else
                <div class="stack-lg">
                    @foreach($order as $item)
                        @php
                            $statusClass = match($item->status) {
                                'Delivered' => 'status-delivered',
                                'On the way', 'Out for delivery' => 'status-onway',
                                'Cancelled' => 'status-cancelled',
                                'Returned' => 'status-cancelled',
                                default => 'status-pending',
                            };
                        @endphp

                        <article class="order-card reveal">
                            <div class="order-head">
                                <div class="pill">{{ $item->payment_status }}</div>
                                <div class="status-pill {{ $statusClass }}">{{ $item->status }}</div>
                            </div>

                            <div class="order-body">
                                <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->title }}">
                                <div>
                                    <h3 style="font-family: var(--serif); font-size: 30px;">{{ $item->product->title }}</h3>
                                    <p class="section-copy" style="margin-top: 8px;">
                                        Quantity: {{ $item->quantity }} |
                                        Unit: Rs. {{ number_format((float) ($item->unit_price ?? $item->product->price), 2) }}
                                    </p>
                                    <p class="muted" style="margin-top: 12px;">
                                        Transaction: {{ $item->transaction_id }}
                                        @if($item->payment_date)
                                            | Paid/Placed: {{ $item->payment_date->format('d M Y, h:i A') }}
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <div class="muted">Order Total</div>
                                    <div class="price-main" style="margin-top: 12px;">Rs. {{ number_format((float) ($item->total_price ?? $item->product->price), 2) }}</div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
