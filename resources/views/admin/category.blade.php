@extends('admin.layout')

@section('admin_kicker', 'Catalog')
@section('admin_title', 'Manage categories')
@section('admin_subtitle', 'Keep your catalog organized with dynamic category counts and cleaner administration controls.')

@section('content')
    <section class="admin-mini-grid">
        <article class="admin-card">
            <div class="admin-kpi">
                <span>Total categories</span>
                <strong>{{ $stats['total'] }}</strong>
            </div>
        </article>
        <article class="admin-card">
            <div class="admin-kpi">
                <span>Largest category</span>
                <strong>{{ $stats['largest']->category_name ?? 'N/A' }}</strong>
            </div>
        </article>
    </section>

    <section class="admin-dashboard-grid">
        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Create category</h3>
                    <div class="admin-muted">New collections appear immediately across the shop filters and admin tools.</div>
                </div>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form-grid">
                @csrf
                <div class="admin-field full">
                    <label>Category name</label>
                    <input type="text" name="category" placeholder="Enter category name" required>
                </div>
                <div class="admin-field full">
                    <button type="submit" class="admin-btn">Add Category</button>
                </div>
            </form>
        </article>

        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Category list</h3>
                    <div class="admin-muted">Every existing category with edit and delete controls.</div>
                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Products</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td data-label="Category"><strong>{{ $item->category_name }}</strong></td>
                                <td data-label="Products">{{ $item->product_count }}</td>
                                <td data-label="Edit"><a href="{{ route('admin.categories.edit', $item->id) }}" class="admin-btn-outline">Edit</a></td>
                                <td data-label="Delete"><a href="{{ route('admin.categories.delete', $item->id) }}" class="admin-btn-outline" onclick="confirmDelete(event)">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('admin_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');

            Swal.fire({
                title: 'Delete this category?',
                text: 'Products already using this category will keep their current category value.',
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
