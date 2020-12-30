<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getfullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
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
        return $this->belongsTo(Profession::class, 'profession_id', 'id');
    }
}
