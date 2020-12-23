<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles=Role::paginate(10);
        return response()->view('cms.spatie.Roles.index', ['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.spatie.Roles.create');
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
        $validator=validator($request->all(), [
            'gard'=>'required|string|in:admin',
            'name'=>'required|string|min:3'
        ]);
        if(!$validator->fails()){
            $role=new Role();
            $role->name=$request->get('name');
            $role->guard_name=$request->get('gard');
            $isSaved=$role->save();
            return response()->json(['message'=>$isSaved ? "Role Created successfuly" : "Failed to create Role"], $isSaved ? 200:400);
        }else{
            return response()->json(['message'=>'Failed to create Role'], 400);
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
        $role = Role::findById($id);
        return response()->view('cms.spatie.Roles.edit', ['role'=>$role]);
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
        $role = Role::findById($id);
        $validator=validator($request->all(), [
            'guard'=>'required|string|in:admin',
            'name'=>'required|string|min:3'
        ]);
        if(!$validator->fails()){
            $role->name=$request->get('name');
            $role->guard_name=$request->get('guard');
            $isSaved=$role->save();
            return response()->json(['message'=>$isSaved ? "Role Updated successfuly" : "Failed to Update Role"], $isSaved ? 200:400);
        }else{
            return response()->json(['message'=>'Failed to Updata Role'], 400);
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
        $isDeleted=Role::destroy($id);
        if($isDeleted){
            return response()->json(['title'=>'Deleted!', 'massege'=>'Role Deleted Successfuly', 'icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Fail!', 'massege'=>'Failed to Delete Role', 'icon'=>'error'],400);
        }
    }
}
