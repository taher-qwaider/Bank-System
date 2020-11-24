<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;
    public function getstutusAttribute(){
        if($this->active)
            return 'Active';
        else
            return 'In Active';
    }
}
