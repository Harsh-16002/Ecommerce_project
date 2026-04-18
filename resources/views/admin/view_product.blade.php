@extends('admin.layout')

@section('admin_kicker', 'Inventory')
@section('admin_title', 'Manage products')
@section('admin_subtitle', 'Search, edit, and monitor your catalog with live product and inventory totals.')

@section('content')
    <section class="admin-stats-grid">
        <article class="admin-card admin-stat-card"><div class="admin-muted">Products</div><div class="admin-stat-value">{{ $stats['products'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Categories</div><div class="admin-stat-value">{{ $stats['categories'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Inventory Units</div><div class="admin-stat-value">{{ $stats['inventory_units'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Low Stock</div><div class="admin-stat-value">{{ $stats['low_stock'] }}</div></article>
    </section>

    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">Catalog table</h3>
                <div class="admin-muted">A cleaner inventory view with quick edit and delete actions.</div>
            </div>
            <a href="{{ route('admin.products.create') }}" class="admin-btn"><i class="fa fa-plus"></i> New Product</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td data-label="Product">
                                <div class="admin-media-row">
                                    <img src="{{ asset('products/'.$item->image) }}" alt="{{ $item->title }}">
                                    <strong>{{ $item->title }}</strong>
                                </div>
                            </td>
                            <td data-label="Description">{{ \Illuminate\Support\Str::limit($item->description, 90) }}</td>
                            <td data-label="Price">Rs. {{ number_format((float) $item->price, 2) }}</td>
                            <td data-label="Category">{{ $item->category }}</td>
                            <td data-label="Qty">{{ $item->quantity }}</td>
                            <td data-label="Edit"><a href="{{ route('admin.products.edit', $item->id) }}" class="admin-btn-outline">Edit</a></td>
                            <td data-label="Delete"><a href="{{ route('admin.products.delete', $item->id) }}" class="admin-btn-outline" onclick="confirmDelete(event)">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination-wrap" style="margin-top: 18px;">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection

@push('admin_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');

            Swal.fire({
                title: 'Delete this product?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endpush
