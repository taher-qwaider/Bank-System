<?php

namespace App\Policies;

use App\Models\Profession;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProfessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Read-Profission') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Profession  $profession
     * @return mixed
     */
    public function view(Admin $admin, Profession $profession)
    {
        //
    }

    /**
     * Determine whether the Admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Create-Profission') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Profession  $profession
     * @return mixed
     */
    public function update(Admin $admin, Profession $profession)
    {
        //
        return $admin->hasPermissionTo('Updata-Profission') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');

    }

    /**
     * Determine whether the Admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Profession  $profession
     * @return mixed
     */
    public function delete(Admin $admin, Profession $profession)
    {
        //
        return $admin->hasPermissionTo('delete-Profission') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');

    }

    /**
     * Determine whether the Admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Profession  $profession
     * @return mixed
     */
    public function restore(Admin $admin, Profession $profession)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Profession  $profession
     * @return mixed
     */
    public function forceDelete(Admin $admin, Profession $profession)
    {
        //
    }
}
