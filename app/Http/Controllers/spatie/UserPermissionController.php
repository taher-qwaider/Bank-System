<?php

namespace App\Http\Controllers\spatie;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        //
        $permissions = Permission::where('guard_name', 'user')->paginate();
        $user = User::findOrFail($userId);

        if ($user->permissions->count() > 0) {
            foreach ($permissions as $permission) {
                $permission->setAttribute('active', false);
                if ($user->hasPermissionTo($permission)) {
                    $permission->setAttribute('active', true);
                }
            }
        }

        return response()->view('cms.User.index-permission', ['permissions' => $permissions, 'userId' => $userId]);
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
        $validator = validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);
        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->get('permission_id'));
            $user = User::findOrFail($userId);
            if ($user->hasPermissionTo($permission)){
                $isGiven = $user->revokePermissionTo($permission);
                return response()->json(['message' => $isGiven ? 'Permission revoked successfuly' : 'Fail to revoke Permission'], $isGiven ? 200 : 400);
            }
            else{
                $isGiven = $user->givePermissionTo($permission);
                return response()->json(['message' => $isGiven ? 'Permission assign successfuly' : 'Fail to assign Permission'], $isGiven ? 200 : 400);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
        }
    }
}
