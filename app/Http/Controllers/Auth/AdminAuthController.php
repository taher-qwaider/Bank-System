<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function logout(Request $request){
        Auth('admin')->logout();
        return redirect()->route('login.view');
    }
    public function edit_password(){
        return response()->view('cms.auth.edit-password');
    }
    public function updata_password(Request $request){
        $validator=Validator($request->all(), [
            'current_password'=>'required|string|password:admin,password',
            'new_password'=>'required|string|confirmed',
            'new_password_confirmation'=>'required|string'
        ]);
        if(!$validator->fails()){
            $admin=$request->user('admin');
            $admin->password=Hash::make($request->get('new_password'));
            $isSaved = $admin->save();
            if($isSaved){
                return response()->json(['message'=>'Password Changed Successfuly'], 200);
            }else{
                return response()->json(['message'=>'failed to Change Password'], 400);
            }
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
        }
    }
    public function edit_profile(Request $request){
        $cities =City::where('active', true)->get();
        $professions =Profession::where('active', true)->get();
        return response()->view('cms.auth.edit-profile', ['cities'=>$cities, 'professions'=>$professions, 'admin'=>$request->user('admin')]);
    }
    public function updata_profile(Request $request){
        $admin =$request->user('admin');
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:admins,email, ' .$admin->id,
            'mobile' => 'required|numeric|digits:10|unique:admins,mobile, ' .$admin->id,
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id'
        ]);

        if (!$validator->fails()) {
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->city_id = $request->get('city_id');
            $admin->gender = $request->get('gender');
            $admin->profession_id=$request->get('profession_id');
            $isSaved = $admin->save();
            return response()->json(['message' => $isSaved ? 'Admin Updataed successfully' : 'Failed to Updata admin'], $isSaved ? 200 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }

    }
}
