<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeType extends Model
{
    use HasFactory;

    public function getStatusAttribute(){
        if($this->active){
            return "Active";
        }else{
            return "Inactive";
        }
    }
}
