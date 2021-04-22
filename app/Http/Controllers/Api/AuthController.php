<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){

     $credentials = $request->only('email','password');

     if(Auth::attempt($credentials)){ 
        $user = Auth::user(); 
        $jwt =  $user->createToken('access_token')-> accessToken; 
        $success = true;

       // $data = compact('user', 'jwt');
        return compact('success','user','jwt');
        //return response()->json(['success' => $success], $this-> successStatus); 
     } 
     else{ 
         $success = false;
         $message = 'Invalid credentials';
         return compact('success', 'message'); 
        //return response()->json(['error'=>'Unauthorised'], 401); 
     } 
    } 

    public function logout(){
       
           if (Auth::check()) {
                Auth::user()->token()->revoke();

                $success = true;

                return compact('success');
            } 
         
    }

    public function register(Request $request)
    {
        $request->validate(User::$rules);

        $user = User::createPatient($request);

        event(new Registered($user));

        Auth::guard()->login($user);

        $jwt =  $user->createToken('access_token')-> accessToken; 
        $success = true;

        return compact('success','user','jwt');
    }
}
 