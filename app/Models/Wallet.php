<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    public function getstatusAttribute(){
        if($this->active)
            return 'active';
        else
            return 'inActive';
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
