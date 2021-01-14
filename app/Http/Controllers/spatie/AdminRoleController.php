<?php

namespace App\Http\Controllers\spatie;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $admin = Admin::findOrFail($id);
        $roles = Role::withCount('permissions')->where('guard_name', 'admin')->get();

        if($admin->roles->count() >0){
            foreach($roles as $role){
                $role->setAttribute('active', false);
                if($admin->hasRole($role)){
                    $role->setAttribute('active', true);
                }
            }
        }
        return response()->view('cms.Admins.index-role', [
            'roles' => $roles,
            'adminId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $adminId)
    {
        //
        $valodator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id'
        ]);
        if(!$valodator->fails()){
            $admin = Admin::findOrFail($adminId);
            $role = Role::findOrFail($request->get('role_id'));
            if($admin->hasRole($role)){
                $isRevoked = $admin->removeRole($role);
                return response()->json(['message'=> $isRevoked ? "Role has revoked successfully" : "Fail to revoke role"], $isRevoked ? 200 : 400);
            }else{
                $isGiven = $admin->assignRole($role);
                return response()->json(['message'=> $isGiven ? "Role has assign successfully" : "Fail to assign Role"], $isGiven ? 200 : 400);
            }
        }else{
            return response()->json(['message'=>$valodator->getMessageBag()->first()], 400);
        }
    }
}
