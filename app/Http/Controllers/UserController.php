<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use lluminate\Database\Eloquent\Collection\visits;
use App\Good;
use App\Cart;
use App\User;
use App\Notifications\NewReview;
use App\Notifications\NewCart;
use Auth;
use DB;

class UserController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        if($user){
        // $users = User::where('users.status', '!=', auth()->user()->status)->orWhere('users.department', '=', auth()->user()->department)->orWhere('users.school', '=', auth()->user()->school)->orWhere('users.college', '=', auth()->user()->college)->orderBy('users.created_at', 'desc')->paginate(10);

        // $goods = Good::orderBy('updated_at', 'desc')->where('goods.user_id', $user->id)->paginate(20);
        //$users = User::orderBy('updated_at', 'desc');

        // $reviews = Review::orderBy('reviews.updated_at', 'desc')
        // ->paginate(20);

        $profile_data = [
            'user' => '$user',
            // 'goods' => '$goods',
            // 'reviews' => '$reviews',
        ];
        
        return response()->json($profile_data, 201);
        }else{
            return redirect()->back();
        }
        
    }

    public function stores()
    {
        $users = User::where('users.status', '==', 'seller')->orderBy('users.created_at', 'desc')->paginate(10);
        // if($user){
        // $users = User::where('users.status', '!=', auth()->user()->status)->orWhere('users.department', '=', auth()->user()->department)->orWhere('users.school', '=', auth()->user()->school)->orWhere('users.college', '=', auth()->user()->college)->orderBy('users.created_at', 'desc')->paginate(10);

        $goods = Good::orderBy('updated_at', 'desc')->where('goods.user_id', $user->id)->paginate(20);
        //$users = User::orderBy('updated_at', 'desc');

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $profile_data = [
            'user' => '$user',
            'goods' => '$goods',
            'reviews' => '$reviews',
        ];
        
        return response()->json($profile_data, 201);
        // }else{
        //     return redirect()->back();
        // }
        
    }
}
