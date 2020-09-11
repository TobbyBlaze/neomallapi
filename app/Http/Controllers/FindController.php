<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\Seller;
use DB;
use Illuminate\Support\Facades\Input;

class FindController extends Controller
{
    public function goods(){
        $q = Input::get ( 'q' );
        $goods = Good::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'description', 'LIKE', '%' . $q . '%' )->orWhere ( 'category', 'LIKE', '%' . $q . '%' )->paginate(20);
    
        $find_data = [
            'q' => $q,
            'goods' => $goods,
        ];

        if($q != null){
            if (count($goods)>0){
                return response()->json($find_data);
            }
        }
    }

    public function sellers(){
        $q = Input::get ( 'q' );
        $sellers = Seller::where ( 'name', 'LIKE', '%' . $q . '%' )->paginate(20);

        $find_data = [
            'q' => $q,
            'seller' => $sellers,
        ];

        if($q != null){
            if (count($sellers)>0){
                return response()->json($find_data);
            }
        }
    }
}
