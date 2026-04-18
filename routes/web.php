<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'Home']);
Route::get('/dashboard', [HomeController::class, 'login_home'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('view_category', [AdminController::class, 'view_category'])->name('admin.categories.index');
    Route::post('add_category', [AdminController::class, 'add_category'])->name('admin.categories.store');
    Route::get('delete_category/{id}', [AdminController::class, 'delete_category'])->name('admin.categories.delete');
    Route::get('edit_category/{id}', [AdminController::class, 'edit_category'])->name('admin.categories.edit');
    Route::post('update_category/{id}', [AdminController::class, 'update_category'])->name('admin.categories.update');

    Route::get('add_product', [AdminController::class, 'add_product'])->name('admin.products.create');
    Route::post('upload_product', [AdminController::class, 'upload_product'])->name('admin.products.store');
    Route::get('view_product', [AdminController::class, 'view_product'])->name('admin.products.index');
    Route::get('search_product', [AdminController::class, 'search_product'])->name('admin.products.search');
    Route::get('update_product/{id}', [AdminController::class, 'update_product'])->name('admin.products.edit');
    Route::post('edit_product/{id}', [AdminController::class, 'edit_product'])->name('admin.products.update');
    Route::get('delete_product/{id}', [AdminController::class, 'delete_product'])->name('admin.products.delete');

    Route::get('view_orders', [AdminController::class, 'view_orders'])->name('admin.orders.index');
    Route::get('admin/orders/{id}', [AdminController::class, 'show_order'])->name('admin.orders.show');
    Route::post('admin/orders/{id}/status', [AdminController::class, 'update_order_status'])->name('admin.orders.status');
    Route::get('print_pdf/{id}', [AdminController::class, 'print_pdf'])->name('admin.orders.invoice');

    Route::get('admin/customers', [AdminController::class, 'view_customers'])->name('admin.customers.index');
    Route::get('admin/payments', [AdminController::class, 'view_payments'])->name('admin.payments.index');
    Route::get('admin/messages', [AdminController::class, 'view_messages'])->name('admin.messages.index');
    Route::get('admin/messages/{id}', [AdminController::class, 'show_message'])->name('admin.messages.show');
    Route::post('admin/messages/{id}/read', [AdminController::class, 'mark_message_read'])->name('admin.messages.read');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings.index');
    Route::post('admin/settings', [AdminController::class, 'update_settings'])->name('admin.settings.update');
});

Route::get('product_details/{id}', [HomeController::class, 'product_details']);
Route::get('/shop', [HomeController::class, 'shop'])->name('shop.index');
Route::get('/why-us', [HomeController::class, 'why'])->name('why.index');
Route::get('testimonial', [HomeController::class, 'testimonial'])->name('testimonial.index');
Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us.index');

Route::get('add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);
Route::post('update_cart/{id}', [HomeController::class, 'update_cart'])->middleware(['auth', 'verified'])->name('cart.update');
Route::get('mycart', [HomeController::class, 'mycart'])->middleware(['auth', 'verified']);
Route::post('contact-us', [HomeController::class, 'store_contact_message'])->name('contact-us.store');

Route::get('remove_cart/{id}', [HomeController::class, 'remove_cart'])->middleware(['auth', 'verified']);

Route::post('payment_page', [HomeController::class, 'payment_page'])
    ->middleware(['auth', 'verified']);

Route::get('paypal/payment', [PaypalController::class, 'payment'])
    ->middleware(['auth', 'verified'])
    ->name('paypal.payment');

Route::post('order_data', [HomeController::class, 'order_data'])->middleware(['auth', 'verified']);

Route::get('myorders', [HomeController::class, 'myorders'])->middleware(['auth', 'verified']);
Route::get('payment_cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::get('payment_success', [PaymentController::class, 'success'])->name('payment.success');
