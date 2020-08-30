<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Ads;
use App\User;
use App\Notifications\NewCart;
use App\Notifications\NewReview;
use Auth;
use DB;

class AdsController extends Controller
{
    public function index()
    {
        // $user = User::find(auth::user()->id);

        $ads = Ads::orderBy('ads.updated_at', 'desc')
        ->paginate(20);

        $users = User::get();

        $data = [

            // 'user' => $user,
            'ads'=>$ads,
            'users'=>$users,

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
        return view('ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::find(Auth::user()->id);
        // $user = User::find(1);

        $this->validate($request, ['name' => 'required',
        'adsPics' => 'required'
        ]);
        //return 123; 'image' => , 'file' => 'nullable|max:6000'

        // $good = good::create($request->all());
        // return response()->json($good, 201);

        if($request->hasFile('adsPics')){
            // $filenameWithExt = $request->file('goodPics')->getClientOriginalName();
            // $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // $extension = $request->file('goodPics')->getClientOriginalExtension();
            // $filenameToStore = $filename.'_'.time().'.'.$extension;
            // //$path = $request->file('file')->storeAs('public/files/documents', $filenameToStore);
            
            // if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
            //     $path = $request->file('goodPics')->storeAs('public/files/images', $filenameToStore);
            // }

            foreach ($request->file('goodPics') as $sin_good_pics){
                // $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filenameWithExt = $sin_ads_pics->getClientOriginalName();
                //
                $sin_good_pics->move(public_path().'/file/', $filenameWithExt);
                $ads_pics_data[] = $filenameWithExt;
                
                $extension = $sin_ads_pics->getClientOriginalExtension();
            }

            //create good

            $ads = new Ads;
            $ads->name = $request->input('name');
            $ads->description = $request->input('description');
            $ads->price = $request->input('price');
            $ads->category = $request->input('category');
            $ads->quantity = $request->input('quantity');
            $ads->seller_id = Auth::user()->id;
            $ads->image = json_encode($ads_pics_data);
            // $good->user_id = Auth::guard('seller')->user()->id;
            // $good->seller_id = Auth::guard('seller')->user()->id;
            // $good->user_id = 1;
        
            // if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif"){
            //     $good->image = $filenameToStore;
            // }
            
            $ads->save();

            // return redirect('/')->with('success', 'good created successfully');
            return response()->json($ads, 201);
            
        }else{
            $filenameToStore = 'NoFile';

            //create good

            $ads = new Ads;
            $ads->name = $request->input('name');
            $ads->description = $request->input('description');
            $ads->price = $request->input('price');
            $ads->category = $request->input('category');
            $ads->quantity = $request->input('quantity');
            $ads->seller_id = Auth::user()->id;
            // $good->seller_id = Auth::guard('seller')->user()->id;
            // $good->user_id = 1;
        
            $ads->save();

            // return redirect('/')->with('success', 'good created successfully');
            return response()->json($ads, 201);
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
        $ad = Ads::find($id);

        // $user = User::find($id);

        $adss = Ads::all();

        $ads_data = [
            'ad' => $ad,
            'ads' => $ads,
            // 'user' => '$user',
            // 'users' => $users,
           
        ];

        return response()->json($ads_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ads = Good::find($id);
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
