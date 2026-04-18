@extends('admin.layout')

@section('admin_kicker', 'Catalog Editing')
@section('admin_title', 'Update product')
@section('admin_subtitle', 'Refresh pricing, category, stock, and imagery without leaving the admin workspace.')

@section('content')
    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">{{ $data->title }}</h3>
                <div class="admin-muted">Current stock {{ $data->quantity }} | Category {{ $data->category }}</div>
            </div>
        </div>

        <form action="{{ url('edit_product', $data->id) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
            @csrf
            <div class="admin-field">
                <label>Title</label>
                <input type="text" name="title" value="{{ $data->title }}" required>
            </div>
            <div class="admin-field">
                <label>Category</label>
                <select name="category" required>
                    @foreach($category as $item)
                        <option value="{{ $item->category_name }}" @selected($item->category_name === $data->category)>{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-field">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ $data->price }}" required>
            </div>
            <div class="admin-field">
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ $data->quantity }}" required>
            </div>
            <div class="admin-field full">
                <label>Description</label>
                <textarea name="description" required>{{ $data->description }}</textarea>
            </div>
            <div class="admin-field">
                <label>Current image</label>
                <img src="{{ asset('products/'.$data->image) }}" alt="{{ $data->title }}" class="admin-preview-image">
            </div>
            <div class="admin-field">
                <label>Replace image</label>
                <input type="file" name="image">
            </div>
            <div class="admin-field full">
                <button type="submit" class="admin-btn">Update Product</button>
            </div>
        </form>
    </section>
@endsection
