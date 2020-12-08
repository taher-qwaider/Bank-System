<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function getstatusAttribute(){
        if($this->active)
            return "Active";
        else
            return "In Active";
    }
    public function admins(){
        return $this->hasMany(Admin::class, 'city_id', 'id');
    }
}
