<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class PaypalController extends Controller
{
    // Declare the total amount as a class property
    private $total = 1000; // Amount in USD

    public function payment()
    {

        if (Auth::check()) {
            $user = Auth::user();
            $userid = $user->id;
            $cart = Cart::where('user_id', $userid)->get();
        } else {
            $cart = collect(); // return an empty collection if the user is not authenticated
        }
        $totalValue = 0;
    foreach ($cart as $cart_item) {
      $totalValue += $cart_item->product->price;
    }

        
        $provider = new PayPalClient();

        // Set up PayPal Client credentials (make sure these are configured correctly)
        $provider->setApiCredentials(config('paypal'));

        // Get access token
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        // Create an order
        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => 'EUR',
                        "value" => $totalValue // Accessing the class property
                    ]
                ]
            ],
            'application_context' => [
                'cancel_url' => route('payment.cancel'),
                'return_url' => route('payment.success')
            ]
        ]);

        // Check if the order was created successfully
        if (isset($order['id'])) {
            // Redirect user to PayPal for payment
            return redirect($order['links'][1]['href']);
        } else {
            // Handle errors (e.g., log them or display an error message)
            return redirect()->back()->with('error', 'There was an issue with the PayPal transaction. Please try again.');
        }
    }
}
