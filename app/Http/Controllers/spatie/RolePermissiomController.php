<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissiomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $role = Role::findOrFail($id);
        $permissions = Permission::where('guard_name', $role->guard_name)->get();

        if($role->permissions->count() >0){
            foreach($permissions as $permission){
                $permission->setAttribute('active', false);
                if($role->hasPermissionTo($permission)){
                    $permission->setAttribute('active', true);
                }
            }
        }
        return response()->view('cms.spatie.Roles.index-permission', [
            'permissions' => $permissions,
            'roleId' => $id
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $roleId)
    {
        //
        $valodator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id'
        ]);
        if(!$valodator->fails()){
            $role = Role::findOrFail($roleId);
            $permission = Permission::findOrFail($request->get('permission_id'));
            if($role->hasPermissionTo($permission)){
                $isRevoked = $role->revokePermissionTo($permission);
                return response()->json(['message'=> $isRevoked ? "Permission has revoked successfully" : "Fail to revoke Permission"], $isRevoked ? 200 : 400);
            }else{
                $isGiven = $role->givePermissionTo($permission);
                return response()->json(['message'=> $isGiven ? "Permission has assign to the role" : "Fail to assign Permission"], $isGiven ? 200 : 400);
            }
        }else{
            return response()->json(['message'=>$valodator->getMessageBag()->first()], 400);
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
