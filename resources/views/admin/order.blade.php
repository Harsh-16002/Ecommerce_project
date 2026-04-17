@extends('admin.layout')

@section('admin_kicker', 'Orders')
@section('admin_title', 'Order management')
@section('admin_subtitle', 'Track customer delivery status, payment state, totals, and printable invoices in one place.')

@section('content')
    <section class="admin-stats-grid">
        <article class="admin-card admin-stat-card"><div class="admin-muted">Orders</div><div class="admin-stat-value">{{ $stats['total'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Revenue</div><div class="admin-stat-value">Rs. {{ number_format((float) $stats['revenue'], 2) }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Pending</div><div class="admin-stat-value">{{ $stats['pending'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Delivered</div><div class="admin-stat-value">{{ $stats['delivered'] }}</div></article>
    </section>

    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">Recent orders</h3>
                <div class="admin-muted">Everything placed through checkout is available here with quick status actions.</div>
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Shipping</th>
                        <th>Product</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $data)
                        @php
                            $statusClass = match($data->status) {
                                'Delivered' => 'delivered',
                                'On the way', 'Out for delivery' => 'onway',
                                'Cancelled', 'Returned' => 'pending',
                                'Confirmed', 'Packed' => 'processing',
                                default => 'pending',
                            };
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $data->name }}</strong>
                                <div class="admin-muted">{{ $data->phone }}</div>
                            </td>
                            <td>{{ $data->address }}, {{ $data->city }}, {{ $data->state }}, {{ $data->country }}, {{ $data->pincode }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:14px;">
                                    @if($data->product?->image)
                                        <img src="{{ asset('products/'.$data->product->image) }}" alt="{{ $data->product->title }}">
                                    @endif
                                    <div>
                                        <strong>{{ $data->product?->title ?? 'Archived product' }}</strong>
                                        <div class="admin-muted">Qty {{ $data->quantity }} | Rs. {{ number_format((float) ($data->total_price ?? $data->product?->price), 2) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="admin-badge payment">{{ $data->payment_status }}</span></td>
                            <td><span class="admin-badge {{ $statusClass }}">{{ $data->status }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.orders.status', $data->id) }}" style="display:grid;gap:8px;min-width:180px;">
                                    @csrf
                                    <select name="status">
                                        @foreach($orderStatuses as $status)
                                            <option value="{{ $status }}" @selected($data->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="admin-status-btn warning">Update</button>
                                </form>
                            </td>
                            <td>
                                <div style="display:grid;gap:8px;">
                                    <a href="{{ route('admin.orders.show', $data->id) }}" class="admin-btn-outline">View Order</a>
                                    <a href="{{ route('admin.orders.invoice', $data->id) }}" class="admin-btn-outline">Print PDF</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
