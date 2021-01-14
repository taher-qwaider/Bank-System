<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permissions=Permission::paginate(10);
        return response()->view('cms.spatie.Permission.index', ['permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.spatie.Permission.create');
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
            $permission=new Permission();
            $permission->name=$request->get('name');
            $permission->guard_name=$request->get('gard');
            $isSaved=$permission->save();
            return response()->json(['message'=>$isSaved ? "permission Created successfuly" : "Failed to create permission"], $isSaved ? 200:400);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
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
        $permission =Permission::findById($id);
        return response()->view('cms.spatie.Permission.edit', ['permission'=>$permission]);
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
        $permission =Permission::findById($id);
        $validator=validator($request->all(), [
            'guard'=>'required|string|in:admin',
            'name'=>'required|string|min:3'
        ]);
        if(!$validator->fails()){
            $permission->name=$request->get('name');
            $permission->guard_name=$request->get('guard');
            $isSaved=$permission->save();
            return response()->json(['message'=>$isSaved ? "permission Updata successfuly" : "Failed to updata permission"], $isSaved ? 200:400);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
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
        $isDeleted=Permission::destroy($id);
        if($isDeleted){
            return response()->json(['massege'=>'Permission Deleted Successfuly'],200);
        }else{
            return response()->json(['massege'=>'Failed to Delete Permissiom'],400);
        }
    }
}
