<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtUsers extends Model
{
    use HasFactory;

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getStatusAttribute(){
        if($this->gender == 'M'){
            return 'Male';
        }else{
            return 'Female';
        }
    }
    public function debt(){
        return $this->hasMany(Debt::class, 'debt_user_id', 'id');
    }
}
