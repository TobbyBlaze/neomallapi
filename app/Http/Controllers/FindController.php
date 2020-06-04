<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use lluminate\Database\Eloquent\Collection\visits;
use App\Good;
use App\Cart;
use App\User;
use App\Notifications\newGood;
use App\Notifications\newCart;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;

class FindController extends Controller
{
    public function all(){
        $q = Input::get ( 'q' );
        $goods = Good::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'description', 'LIKE', '%' . $q . '%' )->paginate(20);
        // $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'email', 'LIKE', '%' . $q . '%' )->paginate(20);

        // $user1 = User::find(auth::user()->id);
        
        $find_data = [
            'q' => $q,
            'goods' => $goods,
            // 'user' => $user,
            // 'user1' => $user1,
        ];

        if($q != null){
            if (count($goods)>0){
                return response()->json($find_data);
            }
        }else{
            return redirect()->back();
        }
    }
}
