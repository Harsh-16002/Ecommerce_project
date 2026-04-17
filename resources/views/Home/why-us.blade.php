@extends('Home.layout')

@section('title', 'Why Us | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Why Choose Us</div>
                    <h1 class="section-title">A cleaner storefront for the whole buying journey</h1>
                    <p class="section-copy">The redesign is not just decorative. It makes discovery, cart review, payment choice, and order tracking feel like parts of one system.</p>
                </div>
            </div>

            <div class="grid-3">
                <article class="metric-card reveal">
                    <strong>Inventory Aware</strong>
                    <p class="muted">Cart updates and order creation still respect available stock so customers are not promised unavailable quantities.</p>
                </article>
                <article class="metric-card reveal delay-1">
                    <strong>Flexible Payments</strong>
                    <p class="muted">Cash on delivery and PayPal remain available inside a more premium and less confusing checkout interface.</p>
                </article>
                <article class="metric-card reveal delay-2">
                    <strong>Unified Tracking</strong>
                    <p class="muted">Order history keeps payment status, transaction reference, and fulfillment state visible in a single destination.</p>
                </article>
            </div>
        </div>
    </section>
@endsection
