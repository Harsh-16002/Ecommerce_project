@extends('admin.layout')

@section('admin_kicker', 'Messages')
@section('admin_title', 'Customer messages')
@section('admin_subtitle', 'Messages submitted from the storefront contact page show up here for the admin team.')

@section('content')
    <section class="admin-stats-grid">
        <article class="admin-card admin-stat-card"><div class="admin-muted">Messages</div><div class="admin-stat-value">{{ $stats['total'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Unread</div><div class="admin-stat-value">{{ $stats['unread'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Today</div><div class="admin-stat-value">{{ $stats['today'] }}</div></article>
        <article class="admin-card admin-stat-card"><div class="admin-muted">Senders</div><div class="admin-stat-value">{{ $stats['customers'] }}</div></article>
    </section>

    <section class="admin-card">
        <div class="admin-card-head">
            <div>
                <h3 class="admin-card-title">Inbox</h3>
                <div class="admin-muted">Review messages and open them individually for full detail.</div>
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td data-label="Sender">
                                <strong>{{ $message->name }}</strong>
                                <div class="admin-muted">{{ $message->email }}{{ $message->phone ? ' | '.$message->phone : '' }}</div>
                            </td>
                            <td data-label="Subject">{{ $message->subject }}</td>
                            <td data-label="Message">{{ \Illuminate\Support\Str::limit($message->message, 90) }}</td>
                            <td data-label="Status"><span class="admin-badge {{ $message->is_read ? 'delivered' : 'pending' }}">{{ $message->is_read ? 'Read' : 'Unread' }}</span></td>
                            <td data-label="Received">{{ $message->created_at?->format('d M Y h:i A') }}</td>
                            <td data-label="Action">
                                <div class="admin-actions-stack">
                                    <a href="{{ route('admin.messages.show', $message->id) }}" class="admin-btn-outline">View</a>
                                    @if(! $message->is_read)
                                        <form method="POST" action="{{ route('admin.messages.read', $message->id) }}">
                                            @csrf
                                            <button type="submit" class="admin-status-btn warning admin-fill-btn">Mark Read</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" data-label="" class="admin-muted">No customer messages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
