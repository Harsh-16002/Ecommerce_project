<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('admin.*', function ($view) {
            $menuCounts = $this->adminQuickStats();
            $adminNavigation = $this->adminNavigation($menuCounts);

            $view->with([
                'adminNavigation' => $adminNavigation,
                'adminQuickStats' => $menuCounts,
            ]);
        });

        View::composer('Home.*', function ($view) {
            $adminShortcuts = collect();

            if (Auth::check() && Auth::user()?->usertype === 'admin') {
                $adminShortcuts = collect($this->adminNavigation($this->adminQuickStats()))
                    ->flatMap(fn (array $section) => $section['items'])
                    ->filter(fn (array $item) => ! empty($item['url']))
                    ->take(5)
                    ->values();
            }

            $view->with([
                'storefrontAdminShortcuts' => $adminShortcuts,
            ]);
        });
    }

    private function adminQuickStats(): array
    {
        return [
            'orders' => Order::count(),
            'products' => Product::count(),
            'categories' => Category::count(),
            'customers' => User::where('usertype', 'user')->count(),
            'payments' => Payment::count(),
            'messages' => Schema::hasTable('contact_messages') ? ContactMessage::where('is_read', false)->count() : 0,
            'revenue' => (float) Order::sum('total_price'),
        ];
    }

    private function adminNavigation(array $menuCounts): array
    {
        return [
            [
                'label' => 'Core',
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'fa fa-bar-chart', 'url' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                    ['label' => 'Orders', 'icon' => 'fa fa-shopping-cart', 'url' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.*'), 'badge' => $menuCounts['orders']],
                    ['label' => 'Products', 'icon' => 'fa fa-cube', 'url' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*'), 'badge' => $menuCounts['products']],
                    ['label' => 'Categories', 'icon' => 'fa fa-folder-open', 'url' => route('admin.categories.index'), 'active' => request()->routeIs('admin.categories.*'), 'badge' => $menuCounts['categories']],
                    ['label' => 'Add Product', 'icon' => 'fa fa-plus-square', 'url' => route('admin.products.create'), 'active' => request()->routeIs('admin.products.create')],
                ],
            ],
            [
                'label' => 'Operations',
                'items' => [
                    ['label' => 'Customers', 'icon' => 'fa fa-users', 'url' => route('admin.customers.index'), 'active' => request()->routeIs('admin.customers.*'), 'badge' => $menuCounts['customers']],
                    ['label' => 'Payments', 'icon' => 'fa fa-credit-card', 'url' => route('admin.payments.index'), 'active' => request()->routeIs('admin.payments.*'), 'badge' => $menuCounts['payments']],
                    ['label' => 'Messages', 'icon' => 'fa fa-comments', 'url' => route('admin.messages.index'), 'active' => request()->routeIs('admin.messages.*'), 'badge' => $menuCounts['messages']],
                    ['label' => 'Settings', 'icon' => 'fa fa-cog', 'url' => route('admin.settings.index'), 'active' => request()->routeIs('admin.settings.*')],
                    ['label' => 'Analytics', 'icon' => 'fa fa-line-chart', 'url' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                    ['label' => 'Reports', 'icon' => 'fa fa-file-text-o', 'url' => route('admin.payments.index'), 'active' => request()->routeIs('admin.payments.*'), 'badge' => 'Live'],
                    ['label' => 'Invoices', 'icon' => 'fa fa-file-pdf-o', 'url' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.*')],
                ],
            ],
            [
                'label' => 'Coming Soon',
                'items' => [
                    ['label' => 'Marketing', 'icon' => 'fa fa-bullhorn', 'url' => null],
                    ['label' => 'Shipping', 'icon' => 'fa fa-truck', 'url' => null],
                    ['label' => 'Coupons', 'icon' => 'fa fa-ticket', 'url' => null],
                    ['label' => 'Admin Roles', 'icon' => 'fa fa-lock', 'url' => null],
                    ['label' => 'Import / Export', 'icon' => 'fa fa-exchange', 'url' => null],
                ],
            ],
        ];
    }
}
