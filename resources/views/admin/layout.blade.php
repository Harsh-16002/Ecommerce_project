<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    @stack('admin_head')
</head>
<body class="admin-ui">
    <div class="admin-shell">
        @include('admin.sidebar')

        <div class="admin-stage">
            @include('admin.header')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('admin_scripts')
</body>
</html>
