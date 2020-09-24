<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Seller;
use App\Admin;
use Validator;

use App\Notifications\SignupActivate;
use App\Notifications\sellerSignupActivate;
use App\Notifications\adminSignupActivate;

use Stevebauman\Location\Facades\Location;

class AuthController extends ResponseController
{

    use AuthenticatesUsers;

    //create user
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => ['string', 'max:20', 'min:2'],
            // 'last_name' => ['string', 'max:20', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:40', 'unique:users'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $input['activation_token'] = str_random(60);
        $input['activation_token'] = sha1(time());
        $user = User::create($input);
        if($user){
            $success['token'] =  $user->createToken('token')->accessToken;

            $user->notify(new SignupActivate($user));

            $success['message'] = "Registration successfull..";
            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401); 
        }
        
    }
    
    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $credentials = request(['email', 'password']);

        // $credentials['active'] = true;
        // $credentials['deleted_at'] = null;
        
        if(!Auth::attempt($credentials)){
            $error = "Unauthorized";
            return $this->sendError($error, 401);
        }
        $user = $request->user();
        $success['token'] =  $user->createToken('token')->accessToken;
        return $this->sendResponse($success);
    }

    //logout
    public function logout(Request $request)
    {
        
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
            
        
    }

    //getuser
    public function getUser(Request $request)
    {
        //$id = $request->user()->id;
        $user = $request->user();
        if($user){
            return $this->sendResponse($user);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }

    //Activate user account
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }

    //create seller
    public function seller_signup(Request $request)
    {

        $messages = [
            "attachments.max" => "file can't be more than 2."
         ];
        $this->validate($request, [
            'image.*' => 'mimes:jpg,jpeg,bmp,png|max:20000',
            'image' => 'max:2',
        ],$messages);

        $validator = Validator::make($request->all(), [
            // 'name' => ['string', 'max:20', 'min:2'],
            // 'last_name' => ['string', 'max:20', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:40', 'unique:sellers'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['activation_token'] = str_random(60);

        if($request->hasFile('image')){
            foreach ($request->file('image') as $sinfile){
                $filenameWithExt = $sinfile->getClientOriginalName();
                $sinfile->move(public_path().'/file/', $filenameWithExt);
                $data[] = $filenameWithExt;
                $extension = $sinfile->getClientOriginalExtension();
            }

            $input['store_pics'] = json_encode($data);
        }

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
            $ipaddress = '';

        $location = \Location::get($ipaddress);

        $input['city'] = $location->cityName;
        $input['country'] = $location->countryName;

        $seller = Seller::create($input);
        if($seller){
            $success['token'] =  $seller->createToken('token')->accessToken;

            $seller->notify(new sellerSignupActivate($seller));

            $success['message'] = "Registration successfull..";
            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401); 
        }
        
    }
    
    //login seller
    public function seller_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $credentials = request(['email', 'password']);

        // $credentials['active'] = true;
        // $credentials['deleted_at'] = null;

        if(!Auth::guard('seller')->attempt($credentials)){
            $error = "Unauthorized seller";
            return $this->sendError($error, 401);
        }

        $user = Auth::guard('seller')->user();
        $success['token'] =  $user->createToken('token')->accessToken;

        return $this->sendResponse($success);
    }

    //logout seller
    public function seller_logout(Request $request)
    {
        
        $isSeller = $request->user()->token()->revoke();
        if($isSeller){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
            
        
    }

    //getseller
    public function getSeller(Request $request)
    {
        $seller = $request->user();
        
        if($seller){
            return $this->sendResponse($seller);
        }
        else{
            $error = "seller not found";
            return $this->sendResponse($error);
        }
    }

    //Activate seller account
    public function sellerSignupActivate($token)
    {
        $user = Seller::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }


    //create admin
    public function admin_signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => ['string', 'max:20', 'min:2'],
            // 'last_name' => ['string', 'max:20', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:40', 'unique:users'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['activation_token'] = str_random(60);

        $admin = Admin::create($input);
        if($admin){
            $success['token'] =  $admin->createToken('token')->accessToken;

            $admin->notify(new adminSignupActivate($admin));

            $success['message'] = "Registration successfull..";
            return $this->sendResponse($success);
        }
        else{
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401); 
        }
        
    }
    
    //login admin
    public function admin_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $credentials = request(['email', 'password']);

        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if(!Auth::guard('admin')->attempt($credentials)){
            $error = "Unauthorized admin";
            return $this->sendError($error, 401);
        }
        $user = Auth::guard('admin')->user();
        $success['token'] =  $user->createToken('token')->accessToken;
        return $this->sendResponse($success);
    }

    //logout admin
    public function admin_logout(Request $request)
    {
        $isAdmin = $request->user()->token()->revoke();
        if($isAdmin){
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        }
        else{
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
            
        
    }

    //getadmin
    public function getAdmin(Request $request)
    {
        $admin = $request->user();
        if($admin){
            return $this->sendResponse($admin);
        }
        else{
            $error = "admin not found";
            return $this->sendResponse($error);
        }
    }

    //Activate admin account
    public function adminSignupActivate($token)
    {
        $user = Admin::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
}