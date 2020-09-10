<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\review;
use App\User;
use Auth;
use DB;


class ReviewsController extends Controller
{
    public function index()
    {
        $user = User::find(auth::user()->id);
        
        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $data = [
            'user' => $user,
            'reviews'=>$reviews,
        ];

        return response()->json($data,200);
    }

    public function store(Request $request, $id)
    {

        $good = Good::find($id);

        $review = new Review;
        $review->rating = $request->input('rating');
        $review->body = $request->input('body');
        $review->user_id = auth()->user()->id;
        $review->good_id = $good->id;
        
        $review->save();

        return response()->json($review, 201);
    }

    public function show($id)
    {
        $review = Review::find($id);

        $user = User::find($id);

        $users = User::where('users.status', '!=', auth()->user()->status)->orWhere('users.department', '=', auth()->user()->department)->orWhere('users.school', '=', auth()->user()->school)->orWhere('users.college', '=', auth()->user()->college)->orderBy('users.created_at', 'desc')->paginate(10);

        
        $reviews = Review::all();

        $review_data = [
            'review' => '$review',
            'reviews' => '$reviews',
            'user' => '$user',
            'users' => '$users',
        ];

        return response()->json($review_data);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        $review->rating = $request->input('rating');
        $review->body = $request->input('body');
        $review->user_id = auth()->user()->id;
        $review->good_id = $good->id;
        
        $review->save();

        return response()->json($review, 201);
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        
        if(auth()->user()->id === $review->user_id){
            $review->delete();
            return response()->json($review, 201);
        }
    }
}
