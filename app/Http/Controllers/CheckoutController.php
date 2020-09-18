<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

use App\User;
use App\Order;
use Auth;
use DB;

class CheckoutController extends Controller
{
    public function charge(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        try {
            // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            Stripe::setApiKey('sk_test_51FyXZOIfMsn8pOBN2CZG6KzUcUgWlySQBGLW8rP9x7ZL5P32nIyuoPfSG3VPDDqylbhmFYGIF0tuV5whXP7nGeUS00lHF870xd');
        
            $customer = Customer::create(array(
                // 'email' => $request->stripeEmail,
                'email' => $user->email,
                'source' => $request->id
            ));
        
            $charge = Charge::create(array(
                // 'customer' => $request->card->id,
                'customer' => $customer->id,
                'amount' => 1999,
                'currency' => 'usd'
            ));

            $data = [
                'user' => $user,
                'customer'=>$customer,
                'charge'=>$charge,
            ];

            $order = new Order;
        
            $order->user_id = $user->id;
            $order->first_name = $request->input('first_name');
            $order->last_name = $request->input('last_name');
            $order->country = $request->input('country');
            $order->address1 = $request->input('address1');
            $order->address2 = $request->input('address2');
            $order->city = $request->input('city');
            $order->state = $request->input('state');
            $order->zip = $request->input('zip');
            $order->phone = $request->input('phone');
            $order->email = $request->input('email');

            $order->save();
        
            return response()->json($data,200);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
