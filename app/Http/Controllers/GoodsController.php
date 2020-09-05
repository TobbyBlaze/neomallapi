<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

class GoodsController extends Controller
{

    // use AuthenticatesUsers;

    // protected $guard = 'seller';

    // public function __construct()
    // {
    //   $this->middleware('guest:seller', ['except' => ['logout']]);
    // }

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

        $popGoods = Good::orderBy('goods.views', 'desc')
        ->paginate(20);

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        $users = User::get();
        $sellers = Seller::get();

        $data = [

            // 'user' => $user,
            'goods'=>$goods,
            'popGoods'=>$popGoods,
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

        $user = Seller::find(Auth::user()->id);
        // $user = User::find(1);

        $messages = [
            "attachments.max" => "file can't be more than 3."
         ];

        $this->validate($request, [
            // 'name' => 'required',
            'file.*' => 'mimes:jpg,jpeg,bmp,png,gif,pdf,docx,doc,tex,txt,pptx,csv,xlsx,xls|max:20000',
            'file' => 'max:2',
        ], $messages);

        // Read file contents...
        $contents = file_get_contents($request->image->path());

        // ...or just move it somewhere else (eg: local `storage` directory or S3)
        $newPath = $request->image->store('photos', 'public');

        //return 123; 'image' => , 'file' => 'nullable|max:6000'

        // $good = good::create($request->all());
        // return response()->json($good, 201);

        // if($request->hasFile('file')){
            // foreach ($request->file('goodPics') as $sin_good_pics){
            //     // $filenameWithExt = $request->file('file')->getClientOriginalName();
            //     $filenameWithExt = $sin_good_pics->getClientOriginalName();
            //     //
            //     $sin_good_pics->move(public_path().'/file/', $filenameWithExt);
            //     $good_pics_data[] = $filenameWithExt;
                
            //     $extension = $sin_good_pics->getClientOriginalExtension();
            // }


            foreach ($request->file('image') as $sinfile){
                // $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filenameWithExt = $sinfile->getClientOriginalName();
                //
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                
                $extension = $sinfile->getClientOriginalExtension();
            }

            
            // for ($i = 1; $i<3; $i++){
                // $sinfile = array($request->file('file1'), $request->file('file2'));
                // $sinfile1 = $request->file('file1');
                // $filenameWithExt = $sinfile1->getClientOriginalName();
                // $sinfile1->move(public_path().'/file/', $filenameWithExt);
                // $sinfile2 = $request->file('file2');
                // $filenameWithExt = $sinfile2->getClientOriginalName();
                // $sinfile2->move(public_path().'/file/', $filenameWithExt);
                // $data[] = $filenameWithExt;
                
                // $extension = $sinfile->getClientOriginalExtension();
            // }

            //create good

            $good = new Good;
            // $good->name = $request->input('name');
            $good->name = 'abaa';
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->quantity = $request->input('quantity');
            $good->seller_id = Auth::user()->id;
            // $good->image = json_encode($data);
            $good->image = json_encode($contents);
            // $good->user_id = Auth::guard('seller')->user()->id;
            // $good->seller_id = Auth::guard('seller')->user()->id;
            // $good->user_id = 1;
        
            // if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
            //     $good->image = $filenameToStore;
            // }
            
            $good->save();

            // return redirect('/')->with('success', 'good created successfully');
            return response()->json($good, 201);
            
        // }else{
        //     $filenameToStore = 'NoFile';

        //     //create good

        //     $good = new Good;
        //     $good->name = $request->input('name');
        //     $good->description = $request->input('description');
        //     $good->price = $request->input('price');
        //     $good->category = $request->input('category');
        //     $good->quantity = $request->input('quantity');
        //     $good->seller_id = Auth::user()->id;
        //     // $good->seller_id = Auth::guard('seller')->user()->id;
        //     // $good->user_id = 1;
        
        //     $good->save();

        //     // return redirect('/')->with('success', 'good created successfully');
        //     return response()->json($good, 201);
        // }

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

        Good::where('id', '=', $id)
        ->update([
            // Increment the view counter field
            'views' => 
            $good->views + 1        ,
            // Prevent the updated_at column from being refreshed every time there is a new view
            'updated_at' => \DB::raw('updated_at')   
        ]);

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
