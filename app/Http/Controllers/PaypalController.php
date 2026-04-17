<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function payment(): RedirectResponse
    {
        if (! session()->has('checkout_data')) {
            toastr()->timeOut(5000)->closeButton()->addError('Please enter your delivery details before selecting a payment method.');
            return redirect('mycart');
        }

        $cart = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            toastr()->timeOut(5000)->closeButton()->addError('Your cart is empty.');
            return redirect('mycart');
        }

        $totalValue = number_format((float) $cart->sum(function (Cart $item) {
            return ((float) $item->product->price) * (int) $item->quantity;
        }), 2, '.', '');

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency', 'USD'),
                        'value' => $totalValue,
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('payment.cancel'),
                'return_url' => route('payment.success'),
            ],
        ]);

        if (isset($order['id'], $order['links'])) {
            session(['paypal_order_id' => $order['id']]);

            foreach ($order['links'] as $link) {
                if (($link['rel'] ?? null) === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        toastr()->timeOut(5000)->closeButton()->addError('There was an issue starting the PayPal transaction. Please try again.');

        return redirect()->back();
    }
}
