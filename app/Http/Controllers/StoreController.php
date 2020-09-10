<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
// use App\Cart;
use App\Review;
use App\User;
use App\Seller;
use Auth;
use DB;

class StoreController extends Controller
{
    public function index()
    {
        $sellers = Seller::paginate(20);

        $data = [
            'sellers' => $sellers,
        ];

        return response()->json($data,200);
    }

    public function show($id)
    {
        $seller = Seller::find($id);

        $storeGoods = Good::orderBy('goods.updated_at', 'desc')
        ->where('goods.seller_id', $seller->id)
        ->paginate(20);

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $data = [

            'seller' => $seller,
            'storeGoods'=>$storeGoods,
            'reviews' => $reviews,
        ];

        return response()->json($data,200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
