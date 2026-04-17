@extends('admin.layout')

@section('admin_kicker', 'Dashboard')
@section('admin_title', 'Welcome back, Admin')
@section('admin_subtitle', 'Track store performance, top products, live order activity, and inventory pressure from one dashboard.')

@push('admin_head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    @include('admin.body')
@endsection
