@extends('admin.layout')

@section('admin_kicker', 'Customers')
@section('admin_title', 'Customer directory')
@section('admin_subtitle', 'Track who is buying, who is verified, and which customers are driving the most order value.')

@section('content')
    <section class="admin-stats-grid">
        <article class="admin-card admin-stat-card">
            <span class="admin-icon"><i class="fa fa-users"></i></span>
            <div class="admin-muted">Customers</div>
            <div class="admin-stat-value">{{ number_format($stats['total']) }}</div>
            <div class="admin-stat-foot">{{ number_format($stats['buyers']) }} customers have placed orders</div>
        </article>

        <article class="admin-card admin-stat-card">
            <span class="admin-icon"><i class="fa fa-check-circle-o"></i></span>
            <div class="admin-muted">Verified</div>
            <div class="admin-stat-value">{{ number_format($stats['verified']) }}</div>
            <div class="admin-stat-foot">Email verified accounts</div>
        </article>

        <article class="admin-card admin-stat-card">
            <span class="admin-icon"><i class="fa fa-shopping-bag"></i></span>
            <div class="admin-muted">Buyers</div>
            <div class="admin-stat-value">{{ number_format($stats['buyers']) }}</div>
            <div class="admin-stat-foot">Customers with at least one order</div>
        </article>

        <article class="admin-card admin-stat-card">
            <span class="admin-icon"><i class="fa fa-money"></i></span>
            <div class="admin-muted">Customer Revenue</div>
            <div class="admin-stat-value">Rs. {{ number_format((float) $stats['revenue'], 2) }}</div>
            <div class="admin-stat-foot">Total lifetime value from registered buyers</div>
        </article>
    </section>

    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">All Customers</h3>
                <div class="admin-muted">Live customer records pulled from frontend account activity</div>
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Orders</th>
                        <th>Lifetime Value</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>
                                <strong>{{ $customer->name }}</strong>
                                <div class="admin-muted">{{ $customer->email_verified_at ? 'Verified account' : 'Verification pending' }}</div>
                            </td>
                            <td>
                                <div>{{ $customer->email }}</div>
                                <div class="admin-muted">{{ $customer->phone ?: 'No phone added' }}</div>
                            </td>
                            <td>{{ number_format($customer->orders_count) }}</td>
                            <td>Rs. {{ number_format((float) $customer->lifetime_value, 2) }}</td>
                            <td>{{ $customer->created_at?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-muted">No customers found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
