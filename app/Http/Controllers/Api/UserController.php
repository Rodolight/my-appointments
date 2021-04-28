<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function show(){
        return Auth::guard('api')->user();
    }

    public function update(Request $request){

      $user = Auth::guard('api')->user();
      
      $user->name = $request->name;
      $user->phone = $request->phone;
      $user->address = $request->address;
      $user->save();
    }
}
