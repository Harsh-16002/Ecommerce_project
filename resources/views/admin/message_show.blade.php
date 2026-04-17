@extends('admin.layout')

@section('admin_kicker', 'Message Detail')
@section('admin_title', 'View customer message')
@section('admin_subtitle', 'Full customer message details from the storefront contact form.')

@section('content')
    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">{{ $message->subject }}</h3>
                <div class="admin-muted">{{ $message->name }} | {{ $message->email }}{{ $message->phone ? ' | '.$message->phone : '' }}</div>
            </div>
            <span class="admin-badge {{ $message->is_read ? 'delivered' : 'pending' }}">{{ $message->is_read ? 'Read' : 'Unread' }}</span>
        </div>

        <div class="admin-list">
            <div class="admin-list-item">
                <div>
                    <strong>Received</strong>
                    <div class="admin-muted">{{ $message->created_at?->format('d M Y h:i A') }}</div>
                </div>
            </div>
            <div class="admin-list-item" style="align-items:flex-start;">
                <div>
                    <strong>Message</strong>
                    <div class="admin-muted" style="white-space:pre-line;">{{ $message->message }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
