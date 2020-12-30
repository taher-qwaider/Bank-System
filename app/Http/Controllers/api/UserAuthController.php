<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    //

    public function login(Request $request){
        $validator = Validator($request->all(), [
            'email'=>'required|exists:users,email',
            'password'=>'required|string'
        ]);
        if(!$validator->fails()){
            $user = User::where('email', $request->get('email'))->first();
            if(Hash::check($request->get('password'), $user->password)){
                return response()->json(['status'=>true, 'message'=>'Loggid in successfuly'], 200);
            }else{
            return response()->json(['status'=>false, 'message'=>'Failed'], 400);
            }
        }else{
            return response()->json(['status'=>false, 'message'=>$validator->getMessageBag()->first()], 400);
        }
    }
}
