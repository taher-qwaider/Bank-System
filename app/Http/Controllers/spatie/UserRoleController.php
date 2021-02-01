<?php

namespace App\Http\Controllers\spatie;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::withCount('permissions')->where('guard_name', 'user')->get();

        if($user->roles->count() >0){
            foreach($roles as $role){
                $role->setAttribute('active', false);
                if($user->hasRole($role)){
                    $role->setAttribute('active', true);
                }
            }
        }
        return response()->view('cms.User.index-role', [
            'roles' => $roles,
            'userId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        //
        $valodator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id'
        ]);
        if(!$valodator->fails()){
            $user = User::findOrFail($userId);
            $role = Role::findOrFail($request->get('role_id'));
            if($user->hasRole($role)){
                $isRevoked = $user->removeRole($role);
                return response()->json(['message'=> $isRevoked ? "Role has revoked successfully" : "Fail to revoke role"], $isRevoked ? 200 : 400);
            }else{
                $isGiven = $user->assignRole($role);
                return response()->json(['message'=> $isGiven ? "Role has assign successfully" : "Fail to assign Role"], $isGiven ? 200 : 400);
            }
        }else{
            return response()->json(['message'=>$valodator->getMessageBag()->first()], 400);
        }
    }
}
