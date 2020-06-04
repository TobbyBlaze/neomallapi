<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use lluminate\Database\Eloquent\Collection\visits;
use App\Good;
use App\Cart;
use App\Review;
use App\User;
use App\Notifications\NewCart;
use App\Notifications\NewReview;
use Auth;
use DB;

class GoodsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['index']]);
    //     // $this->middleware('cors');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::find(auth::user()->id);

        $goods = Good::orderBy('goods.updated_at', 'desc')
        ->paginate(20);

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $data = [

            // 'user' => $user,
            'goods'=>$goods,
            'reviews' => $reviews,

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
        return view('goods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::find(auth::user()->id);
        // $user = User::find(1);

        $this->validate($request, ['name' => 'required']);
        //return 123; 'image' => , 'file' => 'nullable|max:6000'

        // $good = good::create($request->all());
        // return response()->json($good, 201);

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            }

            //create good

            $good = new Good;
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->user_id = auth()->user()->id;
            // $good->user_id = 1;
        
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $good->image = $filenameToStore;
            }
            
            $good->save();

            // return redirect('/')->with('success', 'good created successfully');
            return response()->json($good, 201);
            
        }else{
            $filenameToStore = 'NoFile';

            //create good

            $good = new Good;
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->user_id = auth()->user()->id;
            // $good->user_id = 1;
        
            $good->save();

            // return redirect('/')->with('success', 'good created successfully');
            return response()->json($good, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $good = Good::find($id);

        // $user = User::find($id);

        $goods = Good::all();

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $good_data = [
            'good' => $good,
            'goods' => $goods,
            // 'user' => '$user',
            // 'users' => $users,
            'reviews' => $reviews,
        ];

        return response()->json($good_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $good = Good::find($id);
        // $good->update($request->all());
        // return response()->json($good, 200);

        $user = User::find($id);

        $users = User::where('users.status', '!=', auth()->user()->status)->orWhere('users.department', '=', auth()->user()->department)->orWhere('users.school', '=', auth()->user()->school)->orWhere('users.college', '=', auth()->user()->college)->orderBy('users.created_at', 'desc')->paginate(10);

        

        $goods = Good::orderBy('goods.updated_at', 'desc');
       
        if(auth()->user()->id !== $good->user_id){
            // return redirect('/')->with('error', 'Unauthorised page');
            return response()->json($error, 401);
        }

        $edit_data = [
            'good' => '$good',
            'user' => 'user',
            'goods' => '$goods',
        ];

        // return view('goods.edit')->with('good', $good)->with('user', $user)->with('users', $users);
        return response()->json($edit_data, 201);
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
        $good = Good::find($id);

        // $good->update($request->all());
        // return response()->json($good, 200);

        $this->validate($request, ['name' => 'required']);
        //return 123;

        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $path = $request->file('file')->storeAs('public/files/images', $filenameToStore);
            }

            //update good

            $good = Good::find($id);
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->user_id = auth()->user()->id;
            //$good->document = $filenameToStore;

            //$extension = $request->file('file')->getClientOriginalExtension();
            
            if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
                $good->image = $filenameToStore;
            }
            
            $good->save();

            // return redirect()->back()->with('success', 'good created successfully');
            return response()->json($good, 201);
            
            
        }else{
            $filenameToStore = 'NoFile';

            //update good

            $good = Good::find($id);
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->user_id = auth()->user()->id;
            //$good->document = $filenameToStore;
            
            $good->save();

            // return redirect()->back()->with('success', 'good updated successfully');
            return response()->json($good, 201);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $good = Good::find($id);
        // $good->delete();
        // return response()->json($good, 200);

        if(auth()->user()->id !== $good->user_id){
            return redirect('/')->with('error', 'Unauthorised page');
        }

        Storage::delete('public/files/documents/'.$good->file);
        Storage::delete('public/files/images/'.$good->image);
        $good->delete();

        return response()->json($good, 201);
    }
}
