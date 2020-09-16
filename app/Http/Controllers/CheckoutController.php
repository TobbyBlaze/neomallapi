<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function charge(Request $request)
    {
        // dd($request->all());

        try {
            // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            Stripe::setApiKey(sk_test_51FyXZOIfMsn8pOBN2CZG6KzUcUgWlySQBGLW8rP9x7ZL5P32nIyuoPfSG3VPDDqylbhmFYGIF0tuV5whXP7nGeUS00lHF870xd);
        
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));
        
            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 1999,
                'currency' => 'usd'
            ));
        
            return 'Charge successful, you get the course!';
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
