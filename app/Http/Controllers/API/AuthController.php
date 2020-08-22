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

class AuthController extends ResponseController
{

    use AuthenticatesUsers;

    // protected $guard = 'seller';

    public function __construct()
    {
      $this->middleware('guest:seller', ['except' => ['logout']]);
    }

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
        $user = User::create($input);
        if($user){
            $success['token'] =  $user->createToken('token')->accessToken;
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
        if(!Auth::attempt($credentials)){
            $error = "Unauthorized";
            return $this->sendError($error, 401);
        }
        $user = $request->user();
        $success['token'] =  $user->createToken('token')->accessToken;
        // $user->api_token = $success['token'];
        // $user->save();
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


    //create seller
    public function seller_signup(Request $request)
    {

        // $messages = [
        //     "attachments.max" => "file can't be more than 3."
        //  ];
        // $this->validate($request, [
        //     'store_pics.*' => 'mimes:jpg,jpeg,bmp,png|max:20000',
        //     // 'store_pics' => 'max:2',
        //     'business_reg_doc.*' => 'mimes:jpg,jpeg,bmp,png,pdf,docx,doc,txt,pptx,csv,xlsx,xls|max:20000',
        //     // 'business_reg_doc' => 'max:2',
        //     'vat_info_doc.*' => 'mimes:jpg,jpeg,bmp,png,pdf,docx,doc,txt,pptx,csv,xlsx,xls|max:20000',
        //     // 'vat_info_doc' => 'max:2',
        // ],$messages);

        // $validator = Validator::make($request->all(), [
        //     // 'name' => ['string', 'max:20', 'min:2'],
        //     // 'last_name' => ['string', 'max:20', 'min:2'],
        //     'email' => ['required', 'string', 'email', 'max:40', 'unique:sellers'],
        //     'password' => ['required'],
        //     'confirm_password' => ['required', 'same:password'],
        // ]);

        // if($validator->fails()){
        //     return $this->sendError($validator->errors());       
        // }

        if($request->hasFile('store_pics')){
            // dd($request->file);
            foreach ($request->file('store_pics') as $sin_store_pics){
                // $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filenameWithExt = $sin_store_pics->getClientOriginalName();
                //
                $sin_store_pics->move(public_path().'/file/', $filenameWithExt);
                $store_pics_data[] = $filenameWithExt;
                
                $extension = $sin_store_pics->getClientOriginalExtension();
            }
        }
        if($request->hasFile('business_reg_doc')){
            foreach ($request->file('business_reg_doc') as $sin_business_reg_doc){
                // $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filenameWithExt = $sin_business_reg_doc->getClientOriginalName();
                //
                $sin_business_reg_doc->move(public_path().'/file/', $filenameWithExt);
                $business_reg_doc_data[] = $filenameWithExt;
                
                $extension = $sin_business_reg_doc->getClientOriginalExtension();
            }
        }
        if($request->hasFile('vat_info_doc')){
            foreach ($request->file('vat_info_doc') as $sin_vat_info_doc){
                // $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filenameWithExt = $sin_vat_info_doc->getClientOriginalName();
                //
                $sin_vat_info_doc->move(public_path().'/file/', $filenameWithExt);
                $vat_info_doc_data[] = $filenameWithExt;
                
                $extension = $sin_vat_info_doc->getClientOriginalExtension();
            }
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $input['store_pics'] = json_encode($store_pics_data);
        // $input['business_reg_doc'] = json_encode($business_reg_doc_data);
        // $input['vat_info_doc'] = json_encode($vat_info_doc_data);
        $seller = Seller::create($input);
        if($seller){
            $success['token'] =  $seller->createToken('token')->accessToken;
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
        if(!Auth::guard('seller')->attempt($credentials)){
            $error = "Unauthorized seller";
            return $this->sendError($error, 401);
        }

        // $seller = $request->seller();
        // $user = $request->seller();
        $user = Auth::guard('seller')->user();
        // $success['token'] =  $seller->createToken('token')->accessToken;
        $success['token'] =  $user->createToken('token')->accessToken;
        // $user->api_token = $success['token'];
        // $user->save();
        return $this->sendResponse($success);
    }

    //logout seller
    public function seller_logout(Request $request)
    {
        
        $isSeller = Auth::guard('seller')->user()->token()->revoke();
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
        //$id = $request->user()->id;
        $seller = Auth::user();
        if($seller){
            return $this->sendResponse($seller);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
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
        $admin = Admin::create($input);
        if($admin){
            $success['token'] =  $admin->createToken('token')->accessToken;
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
        
        $isAdmin = Auth::guard('admin')->user()->token()->revoke();
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
        //$id = $request->user()->id;
        $admin = Auth::guard('admin')->user();
        if($admin){
            return $this->sendResponse($admin);
        }
        else{
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }
}