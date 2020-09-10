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
        $user = User::find(auth::user()->id);

        $ads = Ads::orderBy('ads.updated_at', 'desc')
        ->paginate(20);

        $users = User::get();

        $data = [
            'user' => $user,
            'ads'=>$ads,
            'users'=>$users,
        ];

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $messages = [
            "attachments.max" => "file can't be more than 2."
         ];

        $this->validate($request, [
            'name' => 'required',
            'file.*' => 'mimes:jpg,jpeg,bmp,png,gif|max:20000',
            'file' => 'max:2',
        ], $messages);

        if($request->hasFile('image')){
            
            foreach ($request->file('image') as $sinfile){
                $filenameWithExt = $sinfile->getClientOriginalName();
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                $extension = $sinfile->getClientOriginalExtension();
            }

            //create ads

            $ad = new Ads;
            $ad->name = $request->input('name');
            $ad->description = $request->input('description');
            $ad->price = $request->input('price');
            $ad->category = $request->input('category');
            $ad->quantity = $request->input('quantity');
            $ad->seller_id = Auth::user()->id;
            $ad->image = json_encode($data);

            $ad->save();

            return response()->json($ad, 201);
        }else{
            $filenameToStore = 'NoFile';

            //create ads

            $ad = new Ads;
            $ad->name = $request->input('name');
            $ad->description = $request->input('description');
            $ad->price = $request->input('price');
            $ad->category = $request->input('category');
            $ad->quantity = $request->input('quantity');
            $ad->seller_id = Auth::user()->id;
            
            $ad->save();

            return response()->json($ad, 201);
        }

    }

    public function show($id)
    {
        $ad = Ads::find($id);

        // $user = User::find($id);

        $ads = Ads::all();

        $reviews = Review::orderBy('reviews.updated_at', 'desc')
        ->paginate(20);

        Ads::where('id', '=', $id)
        ->update([
            // Increment the view counter field
            'views' => 
            $ad->views + 1        ,
            // Prevent the updated_at column from being refreshed every time there is a new view
            'updated_at' => \DB::raw('updated_at')   
        ]);

        $ads_data = [
            'ad' => $ad,
            'ads' => $ads,
            // 'user' => '$user',
            // 'users' => $users,
            'reviews' => $reviews,
        ];

        return response()->json($ads_data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth::user()->id);
        $ad = Ads::find($id);

        // $good->update($request->all());
        // return response()->json($good, 200);

        $this->validate($request, ['name' => 'required']);
        //return 123;

        if($request->hasFile('image')){
            
            foreach ($request->file('image') as $sinfile){
                $filenameWithExt = $sinfile->getClientOriginalName();
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                $extension = $sinfile->getClientOriginalExtension();
            }

            //update ads

            $ad->name = $request->input('name');
            $ad->description = $request->input('description');
            $ad->price = $request->input('price');
            $ad->category = $request->input('category');
            $ad->quantity = $request->input('quantity');
            $ad->seller_id = Auth::user()->id;
            $ad->image = json_encode($data);

            $ad->save();

            return response()->json($ad, 201);
        }else{
            $filenameToStore = 'NoFile';

            //update ads

            $ad->name = $request->input('name');
            $ad->description = $request->input('description');
            $ad->price = $request->input('price');
            $ad->category = $request->input('category');
            $ad->quantity = $request->input('quantity');
            $ad->seller_id = Auth::user()->id;
            
            $ad->save();

            return response()->json($ad, 201);
        }

    }

    public function destroy($id)
    {
        $ad = Ads::find($id);
        
        if(Auth::user()->id === $ad->seller_id){
            // Storage::delete('public/files/documents/'.$ad->file);
            // Storage::delete('public/files/images/'.$ad->image);
            $ad->delete();

            return response()->json($ad, 201);
        }
    }
}
