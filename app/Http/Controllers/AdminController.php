<?php

namespace App\Http\Controllers;

use App\Mail\AdminWellcomeEmail;
use App\Models\Admin;
use App\Models\City;
use App\Models\Profession;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //paginate
        $admins=Admin::with(['city', 'profession'])->paginate(10);
        return response()->view('cms.Admins.index', ['admins'=>$admins]);
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
        return response()->view('cms.Admins.create', ['cities'=>$cities, 'professions'=>$professions]);
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
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|numeric|digits:10|unique:admins,mobile',
            'gender' => 'required|in:M,F|string',
            'profession_id'=>'required|integer|exists:professions,id'
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->city_id = $request->get('city_id');
            $admin->gender = $request->get('gender');
            $admin->password = Hash::make('password$');
            $admin->profession_id=$request->get('profession_id');
            $isSaved = $admin->save();
            if($isSaved){
                // Mail::to($admin)->queue(new AdminWellcomeEmail($admin));
                event(new Registered($admin));
            }
            return response()->json(['message' => $isSaved ? 'Admin created successfully' : 'Failed to create admin'], $isSaved ? 201 : 400);
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
        $admin =Admin::findOrFail($id);
        $cities =City::where('active', true)->get();
        $professions =Profession::where('active', true)->get();
        return response()->view('cms.Admins.edit', ['admin'=>$admin, 'cities'=>$cities, 'professions'=>$professions]);
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
        $admin =Admin::findOrFail($id);
        $validator = Validator($request->all(), [
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email|unique:admins,email, ' .$id,
            'mobile' => 'required|numeric|digits:10|unique:admins,mobile, ' .$id,
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
            return response()->json(['message' => $isSaved ? 'Admin Updataed successfully' : 'Failed to Updata admin'], $isSaved ? 201 : 400);
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
        $isDeleted = Admin::destroy($id);
        if($isDeleted){
            return response()->json(['massege'=>'Admin Deleted successfuly'], 202);
        }else{
            return response()->json(['massege'=>'Failed to delete Admin'], 400);
        }
    }
}
