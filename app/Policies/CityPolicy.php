<?php

namespace App\Policies;

use App\Models\City;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Read-Cities') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\City  $city
     * @return mixed
     */
    public function view(Admin $user, City $city)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Create-Cities') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\City  $city
     * @return mixed
     */
    public function update(Admin $admin, City $city)
    {
        //
        return $admin->hasPermissionTo('Updata-Cities') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\City  $city
     * @return mixed
     */
    public function delete(Admin $admin, City $city)
    {
        //
        return $admin->hasPermissionTo('delete-Cities') ? Response::allow() : Response::deny('YOU HAVE NO PERMISSION');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\City  $city
     * @return mixed
     */
    public function restore(Admin $admin, City $city)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\City  $city
     * @return mixed
     */
    public function forceDelete(Admin $admin, City $city)
    {
        //
    }
}
