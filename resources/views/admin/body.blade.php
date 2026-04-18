<section class="admin-stats-grid">
    <article class="admin-card admin-stat-card">
        <span class="admin-icon"><i class="fa fa-money"></i></span>
        <div class="admin-muted">Total Sales</div>
        <div class="admin-stat-value">Rs. {{ number_format((float) $stats['revenue'], 2) }}</div>
        <div class="admin-stat-foot">{{ number_format($stats['delivered']) }} delivered orders completed</div>
    </article>

    <article class="admin-card admin-stat-card">
        <span class="admin-icon"><i class="fa fa-shopping-cart"></i></span>
        <div class="admin-muted">Orders</div>
        <div class="admin-stat-value">{{ number_format($stats['orders']) }}</div>
        <div class="admin-stat-foot">{{ number_format($stats['pending_orders']) }} still in progress</div>
    </article>

    <article class="admin-card admin-stat-card">
        <span class="admin-icon"><i class="fa fa-users"></i></span>
        <div class="admin-muted">Visitors / Customers</div>
        <div class="admin-stat-value">{{ number_format($stats['customers']) }}</div>
        <div class="admin-stat-foot">Registered users currently in the system</div>
    </article>

    <article class="admin-card admin-stat-card">
        <span class="admin-icon"><i class="fa fa-line-chart"></i></span>
        <div class="admin-muted">Conversion</div>
        <div class="admin-stat-value">{{ number_format((float) $stats['conversion_rate'], 1) }}%</div>
        <div class="admin-stat-foot">Average order value Rs. {{ number_format((float) $stats['average_order_value'], 2) }}</div>
    </article>
<div class="admin-dashboard-stack">
    <section class="admin-dashboard-grid">
        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Sales Overview</h3>
                    <div class="admin-muted">Revenue and order volume for the last 6 months</div>
                </div>
            </div>
            <div class="admin-chart">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </article>

        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Top Products</h3>
                    <div class="admin-muted">Best performers by units sold</div>
                </div>
            </div>

            <div class="admin-list">
                @foreach($topProducts as $product)
                    <div class="admin-list-item">
                        <div class="admin-list-thumb">
                            @if($product->image)
                                <img src="{{ asset('products/'.$product->image) }}" alt="{{ $product->title }}">
                            @endif
                        </div>
                        <div class="admin-min-zero">
                            <strong>{{ $product->title }}</strong>
                            <div class="admin-muted">{{ $product->category ?: 'Uncategorized' }}</div>
                        </div>
                        <div class="admin-align-end">
                            <strong>{{ (int) $product->units_sold }}</strong>
                            <div class="admin-muted">sold</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <section class="admin-dashboard-grid">
        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Recent Orders</h3>
                    <div class="admin-muted">Newest customer checkouts</div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="admin-btn-outline">View all</a>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            @php
                                $statusClass = match($order->status) {
                                    'Delivered' => 'delivered',
                                    'On the way' => 'onway',
                                    default => 'pending',
                                };
                            @endphp
                            <tr>
                                <td data-label="Customer">
                                    <strong>{{ $order->user?->name ?? $order->name }}</strong>
                                    <div class="admin-muted">{{ $order->created_at?->format('d M Y') }}</div>
                                </td>
                                <td data-label="Product">{{ $order->product?->title ?? 'Archived product' }}</td>
                                <td data-label="Status"><span class="admin-badge {{ $statusClass }}">{{ $order->status }}</span></td>
                                <td data-label="Total">Rs. {{ number_format((float) $order->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>

        <div class="admin-grid">
            <article class="admin-card">
                <div class="admin-card-head">
                    <div>
                        <h3 class="admin-card-title">Traffic Split</h3>
                        <div class="admin-muted">Dashboard-style source breakdown</div>
                    </div>
                </div>
                <div class="admin-chart short">
                    <canvas id="trafficPieChart"></canvas>
                </div>
            </article>

            <article class="admin-card">
                <div class="admin-card-head">
                    <div>
                        <h3 class="admin-card-title">Reviews & Activity</h3>
                        <div class="admin-muted">Operational notes from live data</div>
                    </div>
                </div>

                <div class="admin-list">
                    @foreach($activityFeed as $item)
                        <div class="admin-list-item">
                            <div class="admin-list-thumb"><i class="fa fa-commenting-o"></i></div>
                            <div class="admin-min-zero">
                                <strong>{{ $item['title'] }}</strong>
                                <div class="admin-muted">{{ $item['description'] }}</div>
                            </div>
                            <div class="admin-muted">{{ $item['time'] }}</div>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
</div>

<script>
    const salesTrendContext = document.getElementById('salesTrendChart');
    const trafficPieContext = document.getElementById('trafficPieChart');
    const mobileDashboard = window.matchMedia('(max-width: 760px)');

    if (salesTrendContext) {
        const salesTrend = @json($salesTrend);

        new Chart(salesTrendContext, {
            type: 'line',
            data: {
                labels: salesTrend.map(item => item.label),
                datasets: [
                    {
                        label: 'Revenue',
                        data: salesTrend.map(item => item.revenue),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.16)',
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Orders',
                        data: salesTrend.map(item => item.orders),
                        borderColor: '#2b2f77',
                        backgroundColor: 'rgba(43, 47, 119, 0.08)',
                        fill: false,
                        tension: 0.35,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: mobileDashboard.matches ? 'bottom' : 'top',
                        labels: {
                            boxWidth: mobileDashboard.matches ? 10 : 16,
                            padding: mobileDashboard.matches ? 12 : 16,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxRotation: 0, autoSkip: true, font: { size: mobileDashboard.matches ? 10 : 12 } },
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#eef2fa' },
                        ticks: { font: { size: mobileDashboard.matches ? 10 : 12 } },
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        display: !mobileDashboard.matches,
                        grid: { display: false },
                        ticks: { font: { size: 12 } },
                    }
                }
            }
        });
    }

    if (trafficPieContext) {
        new Chart(trafficPieContext, {
            type: 'doughnut',
            data: {
                labels: ['Customers', 'Orders', 'Products'],
                datasets: [{
                    data: [{{ $stats['customers'] }}, {{ $stats['orders'] }}, {{ $stats['products'] }}],
                    backgroundColor: ['#6366f1', '#2b2f77', '#a5b4fc'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: mobileDashboard.matches ? 10 : 14,
                            padding: mobileDashboard.matches ? 10 : 14,
                        },
                    },
                }
            }
        });
    }
</script>
