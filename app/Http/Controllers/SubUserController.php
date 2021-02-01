<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Profession;
use App\Models\SubUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SubUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $sub_users = $request->user('user')->subUsers()->with(['mainUser', 'subUser'])->get();
        return response()->view('cms.sub-user.index', [
            'sub_users' => $sub_users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cities=City::where('active', true)->get();
        $professions=Profession::where('active', true)->get();
        return response()->view('cms.sub-user.create', [
            'cities' => $cities,
            'professions' => $professions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'id_number' => 'required|numeric|digits:9',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id',
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->city_id = $request->get('city_id');
            $user->id_number = $request->get('id_number');
            $user->gender = $request->get('gender');
            $user->birth_date = $request->get('birth_date');
            $user->password = Hash::make('password$');
            $user->profession_id=$request->get('profession_id');
            $user->has_control = false;
            $isSaved = $user->save();
            if($isSaved){
                event(new Registered($user));
                $sub_user = new SubUser();
                $sub_user->main_user_id = $request->user('user')->id;
                $sub_user->sub_user_id = $user->id;
                $sub_user->manege_sub = false;
                $isSaved = $sub_user->save();
            }
            return response()->json(['message' => $isSaved ? 'Sub User created successfully' : 'Failed to create Sub User'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sub_user = SubUser::findOrFail($id)->subUser()->with(['city', 'profession'])->first();
        $cities=City::where('active', true)->get();
        $professions=Profession::where('active', true)->get();
        return response()->view('cms.sub-user.edit', [
            'cities'=>$cities,
             'professions'=>$professions,
              'sub_user'=>$sub_user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:users,email,' .$id,
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,' . $id,
            'id_number' => 'required|numeric|digits:9',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id',
        ]);

        if (!$validator->fails()) {
            $user = User::findOrFail($id);
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->city_id = $request->get('city_id');
            $user->id_number = $request->get('id_number');
            $user->gender = $request->get('gender');
            $user->birth_date = $request->get('birth_date');
            $user->profession_id=$request->get('profession_id');
            $isSaved = $user->save();
            return response()->json(['message' => $isSaved ? 'Sub User Updated successfully' : 'Failed to Update Sub User'], $isSaved ? 201 : 400);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $sub_user = SubUser::findOrFail($id);
        $user = $sub_user->subUser;
        if ($user->image) {
            $isDeleted = Storage::disk('public')->delete($user->image);
        }
        $isDeleted = $user->delete();
        if($isDeleted){
            $isDeleted = $sub_user->delete();
            return response()->json(['message'=> $isDeleted ? 'Sub User Deleted successfuly' : 'Faild to delete Sub User'], $isDeleted ? 200:400);
        }else{
            return response()->json(['message'=> 'Faild to delete Sub User'], 400);
        }
    }
}
