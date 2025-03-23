<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function cancel(Request $request){
        dd($request->all());
   }
   public function success(Request $request){
        $provider=new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response=$provider->capturePaymentOrder($request['token']);
        dd($response);
   }
 
}
