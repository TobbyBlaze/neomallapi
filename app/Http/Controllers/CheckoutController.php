<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

use App\User;
use App\Order;
use App\Cart;
use App\Good;
use Auth;
use DB;

class CheckoutController extends Controller
{
    public function charge(Request $request)
    {
        // dd($request->all());
        $user = $request->user();

        try {
            // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            Stripe::setApiKey('sk_test_51FyXZOIfMsn8pOBN2CZG6KzUcUgWlySQBGLW8rP9x7ZL5P32nIyuoPfSG3VPDDqylbhmFYGIF0tuV5whXP7nGeUS00lHF870xd');
        
            $customer = Customer::create(array(
                // 'email' => $request->stripeEmail,
                'email' => $user->email,
                'source' => $request->id
            ));

            $carts = Cart::where('carts.user_id', $user->id)
            ->get();

            // $goodPrice = 0;
            $goodName = [];
            $goodQuantity = [];
            $goodPrice = [];
            $goodSubTotPrice = 0;
            $goodTotPrice = 0;

            foreach ($carts as $cart){
                $goodName[] = $cart->name;
                $goodQuantity[] = $cart->quantity;
                $goodPrice[] = $cart->price;
                $goodSubTotPrice = $goodSubTotPrice + ($cart->price * $cart->quantity);
                $goodTotPrice = $goodTotPrice + ($cart->price * $cart->quantity);

                // $good = Good::find($cart->good_id);
                $good = Good::find(1);

                Good::where('id', '=', $cart->good_id)
                ->update([
                    'quantity' => 
                    $good->quantity - $cart->quantity        ,
                    // Prevent the updated_at column from being refreshed every time there is a new view
                    'updated_at' => \DB::raw('updated_at')   
                ]);
            }

            $charge = Charge::create(array(
                // 'customer' => $request->card->id,
                'customer' => $customer->id,
                'amount' => $goodTotPrice * 100,
                'currency' => 'usd'
            ));

            $order = new Order;
        
            $order->user_id = $user->id;
            // $order->first_name = $request->input('first_name');
            // $order->last_name = $request->input('last_name');
            // $order->country = $request->input('country');
            // $order->address1 = $request->input('address1');
            // $order->address2 = $request->input('address2');
            // $order->city = $request->input('city');
            // $order->state = $request->input('state');
            // $order->zip = $request->input('zip');
            // $order->phone = $request->input('phone');
            // $order->email = $request->input('email');
            $order->first_name = $user->name;
            $order->last_name = $user->last_name;
            $order->country = $user->country;
            // $order->address1 = $user->address1;
            $order->address1 = 'vyuvhbuj';
            $order->address2 = $user->address2;
            $order->city = $user->city;
            $order->state = 'ftycuyh';
            $order->zip = $user->zip;
            $order->phone = $user->phone;
            $order->email = $user->email;
            $order->goodsName = json_encode($goodName);
            $order->goodsQuantity = json_encode($goodQuantity);
            $order->goodsPrice = json_encode($goodPrice);
            $order->subtotal = $goodSubTotPrice;
            $order->total = $goodTotPrice;

            $order->save();

            $data = [
                'user' => $user,
                'customer'=>$customer,
                'charge'=>$charge,
                'order' => $order,
            ];

        
            return response()->json($data,200);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
