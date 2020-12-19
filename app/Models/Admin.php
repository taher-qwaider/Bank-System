<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    public function getfulNameAttribute(){
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
