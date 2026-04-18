@extends('admin.layout')

@section('admin_kicker', 'Order Detail')
@section('admin_title', 'View order')
@section('admin_subtitle', 'Review customer details, product data, payment details, and fulfillment state from one screen.')

@section('content')
    <section class="admin-dashboard-grid">
        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Order summary</h3>
                    <div class="admin-muted">Placed {{ $order->created_at?->format('d M Y h:i A') }}</div>
                </div>
                <span class="admin-badge payment">{{ $order->payment_status }}</span>
            </div>

            <div class="admin-list">
                <div class="admin-list-item">
                    <div>
                        <strong>Customer</strong>
                        <div class="admin-muted">{{ $order->name }} | {{ $order->phone }}</div>
                    </div>
                </div>
                <div class="admin-list-item">
                    <div>
                        <strong>Shipping address</strong>
                        <div class="admin-muted">{{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->country }}, {{ $order->pincode }}</div>
                    </div>
                </div>
                <div class="admin-list-item">
                    <div>
                        <strong>Transaction</strong>
                        <div class="admin-muted">{{ $order->transaction_id ?: 'Cash on Delivery / not available' }}</div>
                    </div>
                </div>
                <div class="admin-list-item">
                    <div>
                        <strong>Total</strong>
                        <div class="admin-muted">Rs. {{ number_format((float) $order->total_price, 2) }}</div>
                    </div>
                </div>
            </div>
        </article>

        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Product and fulfillment</h3>
                    <div class="admin-muted">Update the order status or print an invoice.</div>
                </div>
            </div>

            <div class="admin-list compact" style="margin-bottom: 18px;">
                <div class="admin-list-item">
                    <div class="admin-list-thumb">
                        @if($order->product?->image)
                            <img src="{{ asset('products/'.$order->product->image) }}" alt="{{ $order->product->title }}">
                        @else
                            <i class="fa fa-cube"></i>
                        @endif
                    </div>
                    <div class="admin-min-zero">
                        <strong>{{ $order->product?->title ?? 'Archived product' }}</strong>
                        <div class="admin-muted">{{ $order->product?->category ?? 'Uncategorized' }} | Qty {{ $order->quantity }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" class="admin-form-grid">
                @csrf
                <div class="admin-field full">
                    <label>Order status</label>
                    <select name="status">
                        @foreach($orderStatuses as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field">
                    <button type="submit" class="admin-btn admin-fill-btn">Save Status</button>
                </div>
                <div class="admin-field">
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" class="admin-btn-outline admin-fill-btn">Print Invoice</a>
                </div>
            </form>
        </article>
    </section>
@endsection
