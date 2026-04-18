<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const ORDER_STATUSES = [
        'in progress',
        'Confirmed',
        'Packed',
        'On the way',
        'Out for delivery',
        'Delivered',
        'Cancelled',
        'Returned',
    ];

    public function view_category(): View
    {
        $categories = Category::orderBy('category_name')->get()->map(function (Category $category) {
            $category->product_count = Product::where('category', $category->category_name)->count();

            return $category;
        });

        return view('admin.category', [
            'data' => $categories,
            'stats' => [
                'total' => $categories->count(),
                'mapped_products' => Product::whereNotNull('category')->count(),
                'largest' => $categories->sortByDesc('product_count')->first(),
            ],
        ]);
    }

    public function add_category(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $validated['category'],
        ]);

        toastr()->timeOut(5000)->closeButton()->addSuccess('Category added successfully.');

        return redirect()->back();
    }

    public function delete_category($id): RedirectResponse
    {
        $delete = Category::findOrFail($id);
        $delete->delete();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Category deleted successfully.');

        return redirect()->back();
    }

    public function edit_category($id): View
    {
        $edit = Category::findOrFail($id);

        return view('admin.edit', compact('edit'));
    }

    public function update_category(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255|unique:categories,category_name,' . $id,
        ]);

        $update = Category::findOrFail($id);
        $update->category_name = $validated['category'];
        $update->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Category updated successfully.');

        return redirect()->route('admin.categories.index');
    }

    public function add_product(): View
    {
        return view('admin.add_product', [
            'data' => Category::orderBy('category_name')->get(),
            'stats' => [
                'categories' => Category::count(),
                'products' => Product::count(),
                'low_stock' => Product::whereRaw(Product::integerExpression('quantity') . ' <= ?', [5])->count(),
            ],
        ]);
    }

    public function upload_product(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'required|image|max:4096',
        ]);

        $upload = new Product();
        $upload->title = $validated['title'];
        $upload->description = $validated['description'];
        $upload->price = $validated['price'];
        $upload->quantity = $validated['quantity'];
        $upload->category = $validated['category'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $upload->image = $imagename;
        }

        $upload->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Product added successfully.');

        return redirect()->back();
    }

    public function view_product(): View
    {
        $data = Product::latest('id')->paginate(8);

        return view('admin.view_product', [
            'data' => $data,
            'stats' => [
                'products' => Product::count(),
                'categories' => Category::count(),
                'inventory_units' => (int) Product::sum(DB::raw(Product::integerExpression('quantity'))),
                'low_stock' => Product::whereRaw(Product::integerExpression('quantity') . ' <= ?', [5])->count(),
            ],
        ]);
    }

    public function delete_product($id): RedirectResponse
    {
        $data = Product::findOrFail($id);
        $imagePath = public_path('products/' . $data->image);

        if ($data->image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $data->delete();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Product deleted successfully.');

        return redirect()->back();
    }

    public function update_product($id): View
    {
        return view('admin.update_product', [
            'data' => Product::findOrFail($id),
            'category' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function edit_product(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = Product::findOrFail($id);
        $data->title = $validated['title'];
        $data->description = $validated['description'];
        $data->price = $validated['price'];
        $data->category = $validated['category'];
        $data->quantity = $validated['quantity'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imagename);
            $data->image = $imagename;
        }

        $data->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Product updated successfully.');

        return redirect()->route('admin.products.index');
    }

    public function search_product(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $data = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('category', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->latest('id')
            ->paginate(8)
            ->withQueryString();

        return view('admin.view_product', [
            'data' => $data,
            'stats' => [
                'products' => Product::count(),
                'categories' => Category::count(),
                'inventory_units' => (int) Product::sum(DB::raw(Product::integerExpression('quantity'))),
                'low_stock' => Product::whereRaw(Product::integerExpression('quantity') . ' <= ?', [5])->count(),
            ],
            'searchTerm' => $search,
        ]);
    }

    public function view_orders(): View
    {
        $orders = Order::with(['product', 'user'])->latest()->get();

        return view('admin.order', [
            'order' => $orders,
            'orderStatuses' => self::ORDER_STATUSES,
            'stats' => [
                'total' => $orders->count(),
                'revenue' => (float) $orders->sum('total_price'),
                'pending' => $orders->whereIn('status', ['in progress', 'Confirmed', 'Packed', 'On the way', 'Out for delivery'])->count(),
                'delivered' => $orders->where('status', 'Delivered')->count(),
            ],
        ]);
    }

    public function show_order($id): View
    {
        $order = Order::with(['product', 'user'])->findOrFail($id);

        return view('admin.order_show', [
            'order' => $order,
            'orderStatuses' => self::ORDER_STATUSES,
        ]);
    }

    public function view_customers(): View
    {
        $customers = User::query()
            ->where('usertype', 'user')
            ->withCount('orders')
            ->latest()
            ->get()
            ->map(function (User $customer) {
                $customer->lifetime_value = (float) Order::where('user_id', $customer->id)->sum('total_price');

                return $customer;
            });

        return view('admin.customers', [
            'customers' => $customers,
            'stats' => [
                'total' => $customers->count(),
                'verified' => $customers->whereNotNull('email_verified_at')->count(),
                'buyers' => $customers->where('orders_count', '>', 0)->count(),
                'revenue' => (float) $customers->sum('lifetime_value'),
            ],
        ]);
    }

    public function view_payments(): View
    {
        $payments = Payment::with(['user:id,name,email', 'product:id,title,category'])
            ->latest('payment_date')
            ->latest()
            ->get();

        return view('admin.payments', [
            'payments' => $payments,
            'stats' => [
                'total' => $payments->count(),
                'revenue' => (float) $payments->sum('amount'),
                'today' => (float) $payments->where('payment_date', '>=', now()->startOfDay())->sum('amount'),
                'customers' => $payments->pluck('user_id')->filter()->unique()->count(),
            ],
        ]);
    }

    public function view_messages(): View
    {
        $messages = ContactMessage::latest()->get();

        return view('admin.messages', [
            'messages' => $messages,
            'stats' => [
                'total' => $messages->count(),
                'unread' => $messages->where('is_read', false)->count(),
                'today' => $messages->where('created_at', '>=', now()->startOfDay())->count(),
                'customers' => $messages->pluck('email')->unique()->count(),
            ],
        ]);
    }

    public function show_message($id): View
    {
        $message = ContactMessage::findOrFail($id);

        if (! $message->is_read) {
            $message->is_read = true;
            $message->read_at = now();
            $message->save();
        }

        return view('admin.message_show', [
            'message' => $message,
        ]);
    }

    public function mark_message_read($id): RedirectResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->is_read = true;
        $message->read_at = now();
        $message->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Message marked as read.');

        return redirect()->route('admin.messages.index');
    }

    public function settings(): View
    {
        return view('admin.settings', [
            'admin' => auth()->user(),
        ]);
    }

    public function update_settings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
        ]);

        $admin = auth()->user();
        $admin->fill($validated);
        $admin->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Settings updated successfully.');

        return redirect()->route('admin.settings.index');
    }

    public function update_order_status(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', self::ORDER_STATUSES),
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Order status updated successfully.');

        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $data = Order::findOrFail($id);
        $pdf = Pdf::loadView('admin.invoice', compact('data'));

        return $pdf->download('invoice.pdf');
    }
}
