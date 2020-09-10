<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\Cart;
use App\Review;
use App\User;
use Auth;
use DB;

class CartsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $carts = Cart::orderBy('carts.updated_at', 'desc')
        ->where('carts.user_id', $user->id)
        ->paginate(20);

        $cartsNum = Cart::where('carts.user_id', $user->id)->get()->count();
        
        $data = [

            'user' => $user,
            'carts'=>$carts,
            'cartsNum'=>$cartsNum,

        ];

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $cart = new Cart;
        $cart->name = $request->input('name');
        $cart->description = $request->input('description');
        $cart->price = $request->input('price');
        $cart->category = $request->input('category');
        $cart->quantity = $request->input('quantity');
        $cart->user_id = auth()->user()->id;
        
        $cart->image = $request->file('image');
        
        $cart->save();

        return response()->json($cart, 201);
    }

    public function show($id)
    {
        $cart = Cart::find($id);

        $carts = Cart::all();

        $cart_data = [
            'cart' => $cart,
            'carts' => $carts,
        ];

        return response()->json($cart_data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth::user()->id);

        $cart = Cart::find($id);
        $cart->name = $request->input('name');
        $cart->description = $request->input('description');
        $cart->price = $request->input('price');
        $cart->category = $request->input('category');
        $cart->user_id = auth()->user()->id;
        
        $cart->save();
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        
        $cart->delete();

        return response()->json($cart, 201);
    }

    public function delete(Request $request)
    {
        $del = $request->input('delcart');
        $cart = Cart::find($del);
        // $cart->delete();
        // return response()->json($cart, 200);

        // if(auth()->user()->id !== $cart->user_id){
        //     return redirect('/')->with('error', 'Unauthorised page');
        // }

        // Storage::delete('public/files/documents/'.$cart->file);
        // Storage::delete('public/files/images/'.$cart->image);
        $cart->delete();

        return response()->json($cart, 201);
    }

    public function clear()
    {
        $carts = Cart::orderBy('carts.updated_at', 'desc')
        ->where('carts.user_id', $user->id)
        ->paginate(20);

        $carts->delete();

        return response()->json($cart, 201);
    }
}
