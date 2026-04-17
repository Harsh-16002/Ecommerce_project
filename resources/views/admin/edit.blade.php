@extends('admin.layout')

@section('admin_kicker', 'Category Editing')
@section('admin_title', 'Update category')
@section('admin_subtitle', 'Refine collection names and keep the catalog taxonomy clean.')

@section('content')
    <section class="admin-card">
        <form action="{{ url('update_category', $edit->id) }}" method="POST" class="admin-form-grid">
            @csrf
            <div class="admin-field full">
                <label>Category name</label>
                <input type="text" name="category" value="{{ $edit->category_name }}" required>
            </div>
            <div class="admin-field full">
                <button type="submit" class="admin-btn">Update Category</button>
            </div>
        </form>
    </section>
@endsection
