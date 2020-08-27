<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\Cart;
use App\Review;
use App\User;
use App\Seller;
use App\Notifications\NewCart;
use App\Notifications\NewReview;
use Auth;
use DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $seller = Seller::find($id);
        $storeGoods = Good::orderBy('goods.updated_at', 'desc')
        ->where(goods.seller_id, $seller->id)
        ->paginate(20);

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $users = User::get();
        $sellers = Seller::get();

        $data = [

            // 'user' => $user,
            'storeGoods'=>$storeGoods,
            'reviews' => $reviews,
            'users'=>$users,
            'sellers' => $sellers,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
