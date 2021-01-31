<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Invitation;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    use FileUpload;
    //
    public function showLogin(){
        return response()->view('cms.auth-user.login');
    }
    public function login(Request $request){
        $validator=Validator($request->all(), [
            'email'=>'required|email|exists:users,email',
            'password'=>'required|string|min:3',
            'remember_me'=>'boolean'
        ]);
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        if(!$validator->fails()){
            if(Auth::guard('user')->attempt($credentials, $request->get('remember_me'))){
                return response()->json(['message'=>'Logged in successfuly'], 200);
            }else{
                return response()->json(['message'=>'Login Failed check the Credentials'], 400);
            }
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
        }
    }
    public function logout(Request $request){
        Auth('user')->logout();
        return redirect()->route('user.login');
    }
    public function edit_password(){
        return response()->view('cms.auth-user.edit-password');
    }
    public function updata_password(Request $request){
        $validator=Validator($request->all(), [
            'current_password'=>'required|string|password:user,password',
            'new_password'=>'required|string|confirmed',
            'new_password_confirmation'=>'required|string'
        ]);
        if(!$validator->fails()){
            $user=$request->user('user');
            $user->password=Hash::make($request->get('new_password'));
            $isSaved = $user->save();
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
        return response()->view('cms.auth-user.edit-profile', ['cities'=>$cities, 'professions'=>$professions, 'user'=>$request->user('user')]);
    }
    public function updata_profile(Request $request){
        $user =$request->user('user');
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:users,email, ' .$user->id,
            'mobile' => 'required|numeric|digits:10|unique:users,mobile, ' .$user->id,
            'id_number' => 'required|numeric|digits:9',
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id'
        ]);

        if (!$validator->fails()) {
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->city_id = $request->get('city_id');
            $user->id_number = $request->get('id_number');
            $user->gender = $request->get('gender');
            $user->profession_id=$request->get('profession_id');
            if ($request->hasFile('image')) {
                $isDeleted = Storage::disk('public')->delete($user->image);
                if ($isDeleted) {
                    $this->uploadFile($request->file('image'), 'images/users/', 'public', 'user_'. $user->first_name. '_' . time());
                    $user->image = $this->filePath;
                }else{
                    return response()->json(['message' => 'Failed to Upload image'], 400);
                }
            }
            $isSaved = $user->save();
            return response()->json(['message' => $isSaved ? 'User Profile Updated successfully' : 'Failed to Updatad User Profile'], $isSaved ? 200 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }

    }
    public function inviate(){
        return response()->view('cms.inviate');
    }
    public function sendInvietation(Request $request){
        $validator = validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'message' => 'required|string|min:3'
        ]);
        if(!$validator->fails()){
            $sender_id = $request->user('user')->id;
            $resever_id = User::where('email', $request->get('email'))->first()->id;
            $inviate =new Invitation();
            $inviate->sender_user_id = $sender_id;
            $inviate->receiver_user_id = $resever_id;
            $inviate->message =$request->get('message');
            $inviate->status = 'Waiting';
            $isSaved = $inviate->save();
            return response()->json(['message' => $isSaved ? 'Inviatetion send successfully' : 'Failed to send Inviatetion'], $isSaved ? 200 : 400);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }
}
