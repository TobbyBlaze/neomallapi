<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use lluminate\Database\Eloquent\Collection\visits;
use App\Good;
use App\Cart;
use App\Review;
use App\User;
use App\Notifications\NewReview;
use App\Notifications\NewCart;
use Auth;
use DB;

class CartsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     // $this->middleware('cors');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth::user()->id);
        // $user = User::find(1);
        
        // $carts = cart::orderBy('carts.updated_at', 'desc')->paginate(20);
        // $carts = cart::orderBy('carts.updated_at', 'desc')
        // ->select('carts.*')
        // ->join('followers', 'followers.leader_id', '=', 'carts.user_id')
        // // ->where([['followers.follower_id', '=', $user->id], ['carts.user_id', '=', '1']])
        // // ->where('carts.user_id', $user->id)
        // ->where('followers.follower_id', $user->id)
        // ->paginate(20);

        $carts = Cart::orderBy('carts.updated_at', 'desc')
        ->where('carts.user_id', $user->id)
        ->paginate(20);

        // dd($carts);

        // $reviews = Review::orderBy('reviews.updated_at', 'desc')
        // ->paginate(20);

        // return view('carts.index', compact('user', 'users', 'followers' , 'followings', 'carts'), ['user' => $user])->with('carts', $carts)->with('user', $user)->with('reviews', $reviews);

        $data = [

            'user' => $user,
            'carts'=>$carts,
            // 'reviews' => $reviews,

        ];

        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $good = Good::find($id);

        // $cart = new Cart;
        // $cart->user_id = auth()->user()->id;
        // $cart->good_id = $request->input('id');
        // // $cart->user_id = 1;
        // $cart->good_id = $good->id;
        
        // $cart->save();

        $cart = new Cart;
        $cart->name = $request->input('name');
        $cart->description = $request->input('description');
        $cart->price = $request->input('price');
        $cart->category = $request->input('category');
        $cart->quantity = $request->input('quantity');
        $cart->user_id = auth()->user()->id;
        // $cart->user_id = 1;
    
        // if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
            // $cart->image = $filenameToStore;
        // }

        $cart->image = $request->file('file');
        
        $cart->save();

        // return redirect('/')->with('success', 'cart created successfully');
        return response()->json($cart, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::find($id);

        // $user = User::find($id);

        $carts = Cart::all();

        $reviews = review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $cart_data = [
            'cart' => $cart,
            'carts' => $carts,
            // 'user' => $user,
            'reviews' => $reviews,
        ];

        return response()->json($cart_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
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
        $cart = Cart::orderBy('carts.updated_at', 'desc')
        ->where('carts.user_id', $user->id)
        ->paginate(20);
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
}
