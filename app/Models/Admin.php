<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasFactory, Notifiable, SoftDeletes;

    public function getfullNameAttribute(){
        return $this->first_name. ' '.$this->last_name;
    }
    public function getgenderStatusAttribute(){
        if($this->gender=='M')
            return 'Male';
        else
            return "Female";
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function profession(){
        return $this->belongsTo(Profession::class);
    }
}
