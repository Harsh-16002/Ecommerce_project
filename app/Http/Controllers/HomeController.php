<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $totalCustomers = User::where('usertype', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();
        $totalRevenue = (float) Order::sum('total_price');
        $pendingOrders = Order::where('status', 'in progress')->count();
        $lowStockProducts = Product::where('quantity', '<=', 5)->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $conversionRate = $totalOrders > 0 ? ($deliveredOrders / $totalOrders) * 100 : 0;

        $recentOrders = Order::with(['product:id,title,image,category', 'user:id,name'])
            ->latest()
            ->take(6)
            ->get();

        $topProducts = Product::leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->select(
                'products.id',
                'products.title',
                'products.image',
                'products.category',
                'products.quantity',
                DB::raw('COALESCE(SUM(orders.quantity), 0) as units_sold'),
                DB::raw('COALESCE(SUM(orders.total_price), 0) as revenue')
            )
            ->groupBy('products.id', 'products.title', 'products.image', 'products.category', 'products.quantity')
            ->orderByDesc('units_sold')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        $lowStockItems = Product::orderBy('quantity')->take(5)->get();

        $categorySales = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'products.category',
                DB::raw('COALESCE(SUM(orders.total_price), 0) as revenue'),
                DB::raw('COALESCE(SUM(orders.quantity), 0) as units')
            )
            ->groupBy('products.category')
            ->orderByDesc('revenue')
            ->take(6)
            ->get();

        $salesTrend = collect(range(5, 0))->map(function (int $offset) {
            $date = now()->subMonths($offset)->startOfMonth();
            $revenue = (float) Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');

            return [
                'label' => $date->format('M'),
                'revenue' => round($revenue, 2),
                'orders' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        })->values();

        $activityFeed = $recentOrders->map(function (Order $order) {
            $customer = $order->user?->name ?? $order->name;
            $product = $order->product?->title ?? 'Archived product';

            return [
                'title' => $customer . ' placed an order',
                'description' => $product . ' • ' . $order->status,
                'time' => $order->created_at?->diffForHumans(),
            ];
        })->take(5);

        return view('admin.index', [
            'stats' => [
                'customers' => $totalCustomers,
                'products' => $totalProducts,
                'orders' => $totalOrders,
                'delivered' => $deliveredOrders,
                'revenue' => $totalRevenue,
                'pending_orders' => $pendingOrders,
                'low_stock' => $lowStockProducts,
                'average_order_value' => $averageOrderValue,
                'conversion_rate' => round($conversionRate, 1),
            ],
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'lowStockItems' => $lowStockItems,
            'categorySales' => $categorySales,
            'salesTrend' => $salesTrend,
            'activityFeed' => $activityFeed,
        ]);
    }

    public function Home(): View
    {
        return view('Home.index', $this->storefrontData());
    }

    public function login_home(): View
    {
        return view('Home.index', $this->storefrontData());
    }

    public function product_details($id): View|RedirectResponse
    {
        $data = Product::find($id);

        if (! $data) {
            toastr()->timeOut(5000)->closeButton()->addError('Product not found.');

            return redirect('/');
        }

        $similarProducts = Product::where('id', '!=', $data->id)
            ->where('category', $data->category)
            ->latest()
            ->take(4)
            ->get();

        return view('Home.product_details', [
            'data' => $data,
            'count' => $this->cartCount(),
            'similarProducts' => $similarProducts,
        ]);
    }

    public function add_cart($id): RedirectResponse
    {
        $product = Product::find($id);

        if (! $product) {
            toastr()->timeOut(5000)->closeButton()->addError('Product not found.');

            return redirect()->back();
        }

        if ((int) $product->quantity < 1) {
            toastr()->timeOut(5000)->closeButton()->addError('This product is currently out of stock.');

            return redirect()->back();
        }

        $userId = Auth::id();

        $cartItem = Cart::firstOrNew([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);

        $nextQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + 1;

        if ($nextQuantity > (int) $product->quantity) {
            toastr()->timeOut(5000)->closeButton()->addError('You cannot add more than the available stock.');

            return redirect()->back();
        }

        $cartItem->quantity = $nextQuantity;
        $cartItem->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Product added to your cart successfully.');

        return redirect()->back();
    }

    public function mycart(): View
    {
        $cart = $this->userCart();

        return view('Home.mycart', [
            'count' => $this->cartCount(),
            'cart' => $cart,
            'subtotal' => $this->cartSubtotal($cart),
        ]);
    }

    public function update_cart(Request $request, $id): RedirectResponse
    {
        $cartItem = Cart::with('product')
            ->where('user_id', Auth::id())
            ->find($id);

        if (! $cartItem || ! $cartItem->product) {
            toastr()->timeOut(5000)->closeButton()->addError('Cart item not found.');

            return redirect()->back();
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['quantity'] > (int) $cartItem->product->quantity) {
            toastr()->timeOut(5000)->closeButton()->addError('Requested quantity is not available.');

            return redirect()->back();
        }

        $cartItem->quantity = $validated['quantity'];
        $cartItem->save();

        toastr()->timeOut(5000)->closeButton()->addSuccess('Cart updated successfully.');

        return redirect()->back();
    }

    public function remove_cart($id): RedirectResponse
    {
        $remove = Cart::where('user_id', Auth::id())->find($id);

        if ($remove) {
            $remove->delete();
            toastr()->timeOut(5000)->closeButton()->addSuccess('Product removed from your cart.');
        }

        return redirect()->back();
    }

    public function payment_page(Request $request): View|RedirectResponse
    {
        $cart = $this->userCart();

        if ($cart->isEmpty()) {
            toastr()->timeOut(5000)->closeButton()->addError('Your cart is empty.');

            return redirect('mycart');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:120',
            'state' => 'required|string|max:120',
            'pin' => 'required|string|max:20',
            'country' => 'required|string|max:120',
        ]);

        session([
            'checkout_data' => $validated,
        ]);

        return view('Home.payment_option', [
            'cart' => $cart,
            'total' => $this->cartSubtotal($cart),
            'count' => $this->cartCount(),
            'shipping' => $validated,
        ]);
    }

    public function order_data(): RedirectResponse
    {
        $result = $this->createOrdersFromCart('Cash on Delivery', 'cash on delivery');

        if (! $result['success']) {
            toastr()->timeOut(5000)->closeButton()->addError($result['message']);

            return redirect('mycart');
        }

        toastr()->timeOut(5000)->closeButton()->addSuccess('Order placed successfully. We will contact you soon.');

        return redirect('myorders');
    }

    public function myorders(): View
    {
        $order = Order::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('Home.order', [
            'count' => $this->cartCount(),
            'order' => $order,
        ]);
    }

    public function shop(Request $request): View
    {
        return view('Home.shop', $this->storefrontData($request, true));
    }

    public function why(): View
    {
        return view('Home.why-us', ['count' => $this->cartCount()]);
    }

    public function testimonial(): View
    {
        return view('Home.testimonial', ['count' => $this->cartCount()]);
    }

    public function contact_us(): View
    {
        return view('Home.contact-us', [
            'count' => $this->cartCount(),
            'contactDefaults' => [
                'name' => Auth::user()?->name,
                'email' => Auth::user()?->email,
                'phone' => Auth::user()?->phone,
                'subject' => old('subject'),
                'message' => old('message'),
            ],
        ]);
    }

    public function store_contact_message(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        toastr()->timeOut(5000)->closeButton()->addSuccess('Your message has been sent to the admin team.');

        return redirect()->route('contact-us.index');
    }

    public function createOrdersFromCart(
        string $paymentStatus,
        string $transactionId,
        ?string $paymentDate = null
    ): array {
        $checkout = session('checkout_data');
        $cart = $this->userCart();

        if (! $checkout) {
            return [
                'success' => false,
                'message' => 'Please provide your delivery details before checkout.',
            ];
        }

        if ($cart->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Your cart is empty.',
            ];
        }

        try {
            DB::transaction(function () use ($checkout, $cart, $paymentStatus, $transactionId, $paymentDate) {
                foreach ($cart as $cartItem) {
                    $product = Product::lockForUpdate()->find($cartItem->product_id);

                    if (! $product) {
                        throw new \RuntimeException('A product in your cart no longer exists.');
                    }

                    if ((int) $product->quantity < (int) $cartItem->quantity) {
                        throw new \RuntimeException("{$product->title} does not have enough stock.");
                    }

                    $unitPrice = (float) $product->price;
                    $quantity = (int) $cartItem->quantity;

                    Order::create([
                        'name' => $checkout['name'],
                        'address' => $checkout['address'],
                        'landmark' => $checkout['landmark'] ?? null,
                        'phone' => $checkout['phone'],
                        'city' => $checkout['city'],
                        'state' => $checkout['state'],
                        'pincode' => $checkout['pin'],
                        'country' => $checkout['country'],
                        'user_id' => Auth::id(),
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $unitPrice * $quantity,
                        'payment_status' => $paymentStatus,
                        'transaction_id' => $transactionId,
                        'payment_date' => $paymentDate,
                    ]);

                    if ($paymentStatus !== 'Cash on Delivery') {
                        Payment::create([
                            'transaction_id' => $transactionId,
                            'amount' => $unitPrice * $quantity,
                            'currency' => config('paypal.currency', 'USD'),
                            'payment_date' => $paymentDate ?? now(),
                            'user_id' => Auth::id(),
                            'product_id' => $product->id,
                        ]);
                    }

                    $product->quantity = (int) $product->quantity - $quantity;
                    $product->save();
                }

                Cart::where('user_id', Auth::id())->delete();
            });
        } catch (\Throwable $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }

        session()->forget('checkout_data');

        return [
            'success' => true,
            'message' => 'Order completed successfully.',
        ];
    }

    private function storefrontData(?Request $request = null, bool $isShop = false): array
    {
        $selectedCategory = (string) ($request?->input('category', '') ?? '');
        $searchTerm = trim((string) ($request?->input('search', '') ?? ''));
        $sort = (string) ($request?->input('sort', 'latest') ?? 'latest');

        $productQuery = Product::query();

        if ($selectedCategory !== '') {
            $productQuery->where('category', $selectedCategory);
        }

        if ($searchTerm !== '') {
            $productQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category', 'like', '%' . $searchTerm . '%');
            });
        }

        match ($sort) {
            'price_low' => $productQuery->orderByRaw('CAST(price AS DECIMAL(10,2)) asc'),
            'price_high' => $productQuery->orderByRaw('CAST(price AS DECIMAL(10,2)) desc'),
            'stock' => $productQuery->orderByRaw('CAST(quantity AS SIGNED) desc'),
            default => $productQuery->latest(),
        };

        $catalogProducts = $isShop
            ? $productQuery->paginate(12)->withQueryString()
            : $productQuery->get();

        $allProducts = Product::latest()->get();
        $categories = Category::orderBy('category_name')
            ->get()
            ->map(function (Category $category) {
                return [
                    'name' => $category->category_name,
                    'product_count' => Product::where('category', $category->category_name)->count(),
                ];
            })
            ->filter(fn (array $category) => $category['product_count'] > 0)
            ->values();

        $topSellingProducts = Product::leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->select(
                'products.id',
                'products.title',
                'products.image',
                'products.category',
                'products.price',
                'products.quantity',
                DB::raw('COALESCE(SUM(orders.quantity), 0) as units_sold')
            )
            ->groupBy('products.id', 'products.title', 'products.image', 'products.category', 'products.price', 'products.quantity')
            ->orderByDesc('units_sold')
            ->take(4)
            ->get();

        $featuredProducts = $allProducts->take(8);
        $newArrivals = $allProducts->take(4);
        $heroProduct = $topSellingProducts->first() ?? $allProducts->first();
        $cart = Auth::check() ? $this->userCart() : collect();
        $cartSubtotal = Auth::check() ? $this->cartSubtotal($cart) : 0;
        $activeCustomers = User::where('usertype', 'user')->count();
        $orderVolume = Order::count();

        return [
            'count' => $this->cartCount(),
            'data' => $catalogProducts,
            'heroProduct' => $heroProduct,
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'topSellingProducts' => $topSellingProducts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'searchTerm' => $searchTerm,
            'selectedSort' => $sort,
            'cartPreview' => $cart->take(3),
            'cartSubtotal' => $cartSubtotal,
            'stats' => [
                'products' => $allProducts->count(),
                'categories' => $categories->count(),
                'active_customers' => $activeCustomers,
                'orders' => $orderVolume,
            ],
        ];
    }

    private function cartCount(): int
    {
        if (! Auth::check()) {
            return 0;
        }

        return (int) Cart::where('user_id', Auth::id())->sum('quantity');
    }

    private function userCart(): Collection
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn (Cart $item) => $item->product !== null)
            ->values();
    }

    private function cartSubtotal(Collection $cart): float
    {
        return (float) $cart->sum(function (Cart $item) {
            return ((float) $item->product->price) * (int) $item->quantity;
        });
    }
}
