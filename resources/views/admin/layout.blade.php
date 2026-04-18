<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    @stack('admin_head')
</head>
<body class="admin-ui">
    <div class="admin-shell">
        <button type="button" class="admin-sidebar-overlay" data-admin-sidebar-close aria-label="Close navigation"></button>
        @include('admin.sidebar')

        <div class="admin-stage">
            @include('admin.header')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('admin_scripts')
    <script>
        (() => {
            const body = document.body;
            const toggleButtons = document.querySelectorAll('[data-admin-sidebar-toggle]');
            const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');

            if (!toggleButtons.length) {
                return;
            }

            const setSidebarState = (isOpen) => {
                body.classList.toggle('admin-sidebar-open', isOpen);
            };

            toggleButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    setSidebarState(!body.classList.contains('admin-sidebar-open'));
                });
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', () => setSidebarState(false));
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 1180) {
                    setSidebarState(false);
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setSidebarState(false);
                }
            });
        })();
    </script>
</body>
</html>
