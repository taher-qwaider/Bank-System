<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;
    public function getfullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getgenderStatusAttribute(){
        if($this->gender=='M')
            return 'Male';
        else
            return "Female";
    }
    public function mainUser(){
        return $this->belongsTo(User::class, 'main_user_id', 'id');
    }
    public function subUser(){
        return $this->belongsTo(User::class, 'sub_user_id', 'id');
    }
}
