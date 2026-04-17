<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function cancel(): RedirectResponse
    {
        toastr()->timeOut(5000)->closeButton()->addError('PayPal payment was cancelled. You can choose another method or try again.');

        return redirect('mycart');
    }

    public function success(): RedirectResponse
    {
        $token = request('token');

        if (! $token) {
            toastr()->timeOut(5000)->closeButton()->addError('Missing PayPal payment token.');
            return redirect('mycart');
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();
        $provider->setAccessToken($accessToken);

        $response = $provider->capturePaymentOrder($token);
        $status = $response['status'] ?? null;

        if ($status !== 'COMPLETED') {
            toastr()->timeOut(5000)->closeButton()->addError('PayPal could not confirm your payment.');
            return redirect('mycart');
        }

        $capture = $response['purchase_units'][0]['payments']['captures'][0] ?? [];
        $transactionId = $capture['id'] ?? ($response['id'] ?? 'paypal-paid');
        $paymentDate = $capture['create_time'] ?? now()->toDateTimeString();

        $result = app(HomeController::class)->createOrdersFromCart(
            'Paid via PayPal',
            $transactionId,
            $paymentDate
        );

        if (! $result['success']) {
            toastr()->timeOut(5000)->closeButton()->addError($result['message']);
            return redirect('mycart');
        }

        session()->forget('paypal_order_id');

        toastr()->timeOut(5000)->closeButton()->addSuccess('Payment received and your order has been placed.');

        return redirect('myorders');
    }
}
