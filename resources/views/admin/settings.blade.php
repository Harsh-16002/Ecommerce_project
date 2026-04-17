@extends('admin.layout')

@section('admin_kicker', 'Settings')
@section('admin_title', 'Admin settings')
@section('admin_subtitle', 'Update the admin profile details used inside the control panel.')

@section('content')
    <section class="admin-dashboard-grid">
        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Profile settings</h3>
                    <div class="admin-muted">These details are saved to the current admin account.</div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" class="admin-form-grid">
                @csrf
                <div class="admin-field">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required>
                </div>
                <div class="admin-field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                </div>
                <div class="admin-field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}">
                </div>
                <div class="admin-field">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address', $admin->address) }}">
                </div>
                <div class="admin-field full">
                    <button type="submit" class="admin-btn">Save Settings</button>
                </div>
            </form>
        </article>

        <article class="admin-card">
            <div class="admin-card-head">
                <div>
                    <h3 class="admin-card-title">Quick admin notes</h3>
                    <div class="admin-muted">Helpful account info tied to this admin profile.</div>
                </div>
            </div>

            <div class="admin-list">
                <div class="admin-list-item">
                    <div>
                        <strong>Verified email</strong>
                        <div class="admin-muted">{{ $admin->email_verified_at ? $admin->email_verified_at->format('d M Y h:i A') : 'Not verified yet' }}</div>
                    </div>
                </div>
                <div class="admin-list-item">
                    <div>
                        <strong>Password management</strong>
                        <div class="admin-muted">Use the main profile flow if you want to change account security details.</div>
                    </div>
                </div>
                <div class="admin-list-item">
                    <div>
                        <strong>Support inbox</strong>
                        <div class="admin-muted">Customer contact-form messages are now available from the Messages menu item.</div>
                    </div>
                </div>
            </div>
        </article>
    </section>
@endsection
