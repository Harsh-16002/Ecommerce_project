@extends('Home.layout')

@section('title', 'Payment Options | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container checkout-layout">
            <div class="panel reveal">
                <div class="eyebrow">Payment Selection</div>
                <h1 class="section-title">Choose how to complete this order</h1>
                <p class="section-copy">Your delivery details are saved for this checkout session. Select the payment flow that fits this order best.</p>

                <div class="stack-lg" style="margin-top: 28px;">
                    <article class="mini-card">
                        <div class="summary-row">
                            <div>
                                <strong style="font-size: 24px;">Cash on Delivery</strong>
                                <p class="muted" style="margin-top: 8px;">Best for quick local checkout with payment collected when the order arrives.</p>
                            </div>
                            <form action="{{ url('order_data') }}" method="POST">
                                @csrf
                                <button type="submit" class="solid-btn">Place COD Order</button>
                            </form>
                        </div>
                    </article>

                    <article class="mini-card">
                        <div class="summary-row">
                            <div>
                                <strong style="font-size: 24px;">PayPal</strong>
                                <p class="muted" style="margin-top: 8px;">Secure online payment with confirmation written back into your order history.</p>
                            </div>
                            <a href="{{ route('paypal.payment') }}" class="outline-btn">Pay with PayPal</a>
                        </div>
                    </article>
                </div>
            </div>

            <aside class="panel reveal delay-1">
                <div class="eyebrow">Order Review</div>
                <h2 class="section-title" style="font-size: 34px;">Summary</h2>

                <div class="stack-md" style="margin-top: 24px;">
                    @foreach($cart as $item)
                        <div class="summary-box">
                            <div class="summary-row">
                                <div>
                                    <strong>{{ $item->product->title }}</strong>
                                    <p class="muted" style="margin-top: 6px;">Qty {{ $item->quantity }}</p>
                                </div>
                                <div>Rs. {{ number_format((float) $item->product->price * $item->quantity, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="summary-box" style="margin-top: 18px;">
                    <div class="muted">Deliver To</div>
                    <p class="section-copy" style="margin-top: 10px;">
                        {{ $shipping['name'] }}<br>
                        {{ $shipping['address'] }}@if(!empty($shipping['landmark'])), {{ $shipping['landmark'] }}@endif<br>
                        {{ $shipping['city'] }}, {{ $shipping['state'] }}, {{ $shipping['country'] }} - {{ $shipping['pin'] }}<br>
                        {{ $shipping['phone'] }}
                    </p>
                </div>

                <div class="summary-box" style="margin-top: 18px;">
                    <div class="summary-row">
                        <span>Total Payable</span>
                        <strong class="price-main" style="font-size: 30px;">Rs. {{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
