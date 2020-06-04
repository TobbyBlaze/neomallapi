<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use lluminate\Database\Eloquent\Collection\visits;
use App\Good;
use App\review;
use App\User;
use App\Notifications\NewCart;
use App\Notifications\NewReview;
use Auth;
use DB;


class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth::user()->id);
        
        // $reviews = review::orderBy('reviews.updated_at', 'desc')->paginate(20);
        // $reviews = review::orderBy('reviews.updated_at', 'desc')
        // ->select('reviews.*')
        // ->join('followers', 'followers.leader_id', '=', 'reviews.user_id')
        // // ->where([['followers.follower_id', '=', $user->id], ['reviews.user_id', '=', '1']])
        // // ->where('reviews.user_id', $user->id)
        // ->where('followers.follower_id', $user->id)
        // ->paginate(20);

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        // dd($reviews);

        // return view('reviews.index', compact('user', 'users', 'followers' , 'followings', 'reviews'), ['user' => $user])->with('reviews', $reviews)->with('user', $user)->with('comments', $comments);

        $data = [

            'user' => $user,
            'reviews'=>$reviews,
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
    public function store(Request $request, $id)
    {

        $good = Good::find($id);

        $review = new Review;
        $review->rating = $request->input('rating');
        $review->body = $request->input('body');
        $review->user_id = auth()->user()->id;
        $review->good_id = $good->id;
        
        $review->save();

        // return redirect('/')->with('success', 'review created successfully');
        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $review = Review::find($id);

        $review = Review::find($id);
        $review->rating = $request->input('rating');
        $review->body = $request->input('body');
        $review->user_id = auth()->user()->id;
        //$review->document = $filenameToStore;
        
        $review->save();

        // return redirect()->back()->with('success', 'review updated successfully');
        return response()->json($review, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        // $review->delete();
        // return response()->json($review, 200);

        if(auth()->user()->id !== $review->user_id){
            return redirect('/')->with('error', 'Unauthorised page');
        }

        $review->delete();

        return response()->json($review, 201);
    }
}
