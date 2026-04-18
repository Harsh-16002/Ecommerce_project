@extends('admin.layout')

@section('admin_kicker', 'Catalog Growth')
@section('admin_title', 'Add a new product')
@section('admin_subtitle', 'Create inventory with better structure so it appears dynamically across the storefront and admin dashboard.')

@section('content')
    <section class="admin-mini-grid">
        <article class="admin-card"><div class="admin-kpi"><span>Categories</span><strong>{{ $stats['categories'] }}</strong></div></article>
        <article class="admin-card"><div class="admin-kpi"><span>Low stock items</span><strong>{{ $stats['low_stock'] }}</strong></div></article>
    </section>

    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">Product details</h3>
                <div class="admin-muted">Everything you add here is reflected in the dynamic home, shop, and admin views.</div>
            </div>
        </div>

        <form action="{{ url('upload_product') }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
            @csrf
            <div class="admin-field">
                <label>Title</label>
                <input type="text" name="title" placeholder="Product title" required>
            </div>
            <div class="admin-field">
                <label>Category</label>
                <select name="category" required>
                    <option value="">Select category</option>
                    @foreach($data as $item)
                        <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-field">
                <label>Price</label>
                <input type="number" step="0.01" name="price" placeholder="0.00" required>
            </div>
            <div class="admin-field">
                <label>Quantity</label>
                <input type="number" name="quantity" placeholder="0" required>
            </div>
            <div class="admin-field full">
                <label>Description</label>
                <textarea name="description" placeholder="Describe the product" required></textarea>
            </div>
            <div class="admin-field full">
                @include('admin.partials.ai_product_assistant')
            </div>
            <div class="admin-field full">
                <label>Product image</label>
                <input type="file" name="image" required>
            </div>
            <div class="admin-field full">
                <button type="submit" class="admin-btn">Add Product</button>
            </div>
        </form>
    </section>
@endsection
