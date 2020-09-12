<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Good;
use App\Wish;
use App\Review;
use App\User;
use Auth;
use DB;

class wishController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $wishes = Wish::orderBy('wishes.updated_at', 'desc')
        ->where('wishes.user_id', $user->id)
        ->paginate(20);

        $wishesNum = Wish::where('wishes.user_id', $user->id)->get()->count();
        
        $data = [

            'user' => $user,
            'wishes'=>$wishes,
            'wishesNum'=>$wishesNum,

        ];

        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $wish = new Wish;
        $wish->name = $request->input('name');
        $wish->description = $request->input('description');
        $wish->price = $request->input('price');
        $wish->category = $request->input('category');
        $wish->quantity = $request->input('quantity');
        $wish->user_id = auth()->user()->id;
        
        $wish->image = $request->file('image');
        
        $wish->save();

        return response()->json($wish, 201);
    }

    public function show($id)
    {
        $wish = Wish::find($id);

        $wishes = Wish::all();

        $wish_data = [
            'wish' => $wish,
            'wishes' => $wishes,
        ];

        return response()->json($wish_data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth::user()->id);

        $wish = Wish::find($id);
        $wish->name = $request->input('name');
        $wish->description = $request->input('description');
        $wish->price = $request->input('price');
        $wish->category = $request->input('category');
        $wish->user_id = auth()->user()->id;
        
        $wish->save();
    }

    public function destroy($id)
    {
        $wish = Wish::find($id);
        
        $wish->delete();

        return response()->json($wish, 201);
    }

    public function delete(Request $request)
    {
        $del = $request->input('delwish');
        $wish = Wish::find($del);
        // $wish->delete();
        // return response()->json($wish, 200);

        // if(auth()->user()->id !== $wish->user_id){
        //     return redirect('/')->with('error', 'Unauthorised page');
        // }

        // Storage::delete('public/files/documents/'.$wish->file);
        // Storage::delete('public/files/images/'.$wish->image);
        $wish->delete();

        return response()->json($wish, 201);
    }

    public function clear()
    {
        $wishes = Wish::orderBy('wishes.updated_at', 'desc')
        ->where('wishes.user_id', $user->id)
        ->paginate(20);

        $wishes->delete();

        return response()->json($wish, 201);
    }
}
