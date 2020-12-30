<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::withCount('permissions')->with(['city', 'profession'])->paginate(10);
        return response()->view('cms.User.index', ['users'=>$users]);
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
        return response()->view('cms.User.create', ['cities'=>$cities, 'professions'=>$professions]);
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
            'id_number' => 'numeric|digits:9',
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id'
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
            $user->password = Hash::make('password$');
            $user->profession_id=$request->get('profession_id');
            $isSaved = $user->save();
            if($isSaved){
                event(new Registered($user));
            }
            return response()->json(['message' => $isSaved ? 'User created successfully' : 'Failed to create User'], $isSaved ? 201 : 400);
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
    }
}
