<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
 
 public function register(Request $request)
 {
   //data validation
   $request->validate([
       'name' => 'required',
       'email' => 'required|email|unique:users',
       'phone_no' => 'required',
       'password' => 'required|confirmed'
   ]);

   //create & store data
   $user = new User();
   $user->name = $request->name;
   $user->email = $request->email;
   $user->phone_no = $request->phone_no;
   $user->password = bcrypt($request->password);
   $user->save();

   //send reponse
   return response()->json([
       "status"=>1,
       "message"=>"user registered succesfully"
   ], 200);

 }
 public function login(Request $request)
 {
    //data validation
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    //verify the user and token
      if( !$token = auth()->attempt(['email' => $request->email, 'password' => $request->password]) )
      {
        return response()->json([
          "status"=>0,
          "message"=>"invalid credentials"
        ]);
      }
        return response()->json([
        "status" => 1,
        "message"=>"logged successfully",
        "access_token"=>$token 
        ]);
      
    //generate token
    //send response
 }
 public function profile()
 {
    $user_data = auth()->user();

    return response()->json([
      "status"=> 1,
      "message"=>" user profile data",
      "data"=> $user_data
    ]);
 }
 public function logout()
 {

 }

}
