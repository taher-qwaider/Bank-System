<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    public function user_debt(){
        return $this->belongsTo(DebtUsers::class, 'debt_user_id', 'id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function payments(){
        return $this->hasMany(DebtPayment::class, 'debt_id', 'id');
    }
}
