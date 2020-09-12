<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\Review;
use App\User;
use App\Seller;
use Auth;
use DB;
use Stevebauman\Location\Facades\Location;

class GoodsController extends Controller
{
    public function index()
    {
        $goods = Good::orderBy('goods.updated_at', 'desc')
        ->paginate(5);

        $popGoods = Good::orderBy('goods.views', 'desc')
        ->paginate(20);

        $data = [
            'goods'=>$goods,
            'popGoods'=>$popGoods,
        ];

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $user = Seller::find(Auth::user()->id);

        $messages = [
            "attachments.max" => "file can't be more than 2."
         ];

        $this->validate($request, [
            'name' => 'required',
            'image.*' => 'mimes:jpg,jpeg,bmp,png,gif|max:20000',
            'image' => 'max:2',
        ], $messages);

        if($request->hasFile('image')){
            
            foreach ($request->file('image') as $sinfile){
                $filenameWithExt = $sinfile->getClientOriginalName();
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                $extension = $sinfile->getClientOriginalExtension();
            }

            //create good

            $good = new Good;
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->quantity = $request->input('quantity');
            $good->seller_id = Auth::user()->id;
            $good->image = json_encode($data);

            $good->save();

            return response()->json($good, 201);
        }else{
            $filenameToStore = 'NoFile';

            //create good

            $good = new Good;
            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->quantity = $request->input('quantity');
            $good->seller_id = Auth::user()->id;
            
            $good->save();

            return response()->json($good, 201);
        }

    }

    public function show($id)
    {
        $good = Good::find($id);

        // $user = User::find($id);

        // $goods = Good::all();

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

        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = request()->ip();

        $location = \Location::get($ipaddress);

        $browserDetails = get_browser($request->header('User-Agent'), true);

        $good_data = [
            'good' => $good,
            // 'goods' => $goods,
            // 'user' => '$user',
            // 'users' => $users,
            'reviews' => $reviews,
            'location' => $location,
            'browserDetails' => $browserDetails,
        ];

        return response()->json($good_data);
    }

    public function update(Request $request, $id)
    {
        $user = Seller::find(Auth::user()->id);
        $good = Good::find($id);

        $this->validate($request, ['name' => 'required']);

        if($request->hasFile('image')){
            
            foreach ($request->file('image') as $sinfile){
                $filenameWithExt = $sinfile->getClientOriginalName();
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                $extension = $sinfile->getClientOriginalExtension();
            }

            //update good

            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->quantity = $request->input('quantity');
            $good->seller_id = Auth::user()->id;
            $good->image = json_encode($data);

            $good->save();

            return response()->json($good, 201);
        }else{
            $filenameToStore = 'NoFile';

            //update good

            $good->name = $request->input('name');
            $good->description = $request->input('description');
            $good->price = $request->input('price');
            $good->category = $request->input('category');
            $good->quantity = $request->input('quantity');
            $good->seller_id = Auth::user()->id;
            
            $good->save();

            return response()->json($good, 201);
        }

    }

    public function destroy($id)
    {
        $good = Good::find($id);
        
        if(Auth::user()->id === $good->seller_id){
            // Storage::delete('public/files/documents/'.$good->file);
            // Storage::delete('public/files/images/'.$good->image);
            $good->delete();

            return response()->json($good, 201);
        }
    }
}
