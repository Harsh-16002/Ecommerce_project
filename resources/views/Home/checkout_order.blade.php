@extends('Home.layout')

@section('title', 'Checkout Complete | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="empty-state reveal">
                <div class="eyebrow" style="justify-content: center;">Checkout Completed</div>
                <h1 class="section-title">Your order summary now lives in My Orders</h1>
                <p class="section-copy" style="margin-left: auto; margin-right: auto;">
                    This handoff screen now matches the rest of the storefront, while the active post-checkout experience stays centered in the real order history flow.
                </p>
                <div class="hero-actions" style="justify-content: center; margin-top: 24px;">
                    <a href="{{ url('myorders') }}" class="solid-btn">View My Orders</a>
                    <a href="{{ route('shop.index') }}" class="outline-btn">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>
@endsection
