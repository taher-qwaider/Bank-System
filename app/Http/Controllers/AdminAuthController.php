<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    //
    public function showLogin(){
        return response()->view('cms.auth.login');
    }
    public function login(Request $request){
        $validator=Validator($request->all(), [
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|string|min:3',
            'remember_me'=>'boolean'
        ]);
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        if(!$validator->fails()){
            if(Auth::guard('admin')->attempt($credentials, $request->get('remember_me'))){
                return response()->json(['massage'=>'Logged in successfuly'], 200);
            }else{
                return response()->json(['massage'=>'Login Failed check the credentials'], 400);
            }
        }else{
            return response()->json(['massage'=>$validator->getMessageBag()->first()], 400);
        }
    }
}
