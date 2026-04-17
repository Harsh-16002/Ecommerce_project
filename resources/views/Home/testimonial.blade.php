@extends('Home.layout')

@section('title', 'Reviews | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">What Customers Say</div>
                    <h1 class="section-title">Feedback that fits the new storefront tone</h1>
                    <p class="section-copy">These review panels now align with the rest of the customer-facing pages instead of looking like a separate template.</p>
                </div>
            </div>

            <div class="grid-3">
                <article class="testimonial-card reveal">
                    <blockquote>"Checkout feels clearer, the product cards look intentional, and the whole store finally feels custom."</blockquote>
                    <strong>Ritika S.</strong>
                    <p class="muted">Verified customer</p>
                </article>
                <article class="testimonial-card reveal delay-1">
                    <blockquote>"I can move from product detail to cart to order tracking without the design changing on me. That builds trust."</blockquote>
                    <strong>Mohit K.</strong>
                    <p class="muted">Repeat customer</p>
                </article>
                <article class="testimonial-card reveal delay-2">
                    <blockquote>"It looks premium now, but the best part is the flow still works like a real ecommerce app underneath."</blockquote>
                    <strong>Anaya P.</strong>
                    <p class="muted">Fashion buyer</p>
                </article>
            </div>
        </div>
    </section>
@endsection
