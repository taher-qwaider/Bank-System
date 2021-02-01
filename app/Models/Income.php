<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
    public function incomeType(){
        return $this->belongsTo(IncomeType::class, 'income_type_id', 'id');
    }
}
