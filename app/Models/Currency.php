<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    public function getStatusAttribute(){
        if($this->active){
            return "Active";
        }else{
            return "Inactive";
        }
    }
    public function wallets(){
        return $this->hasMany(Wallet::class, 'currency_id', 'id');
    }
    public function financialOperations(){
        return $this->hasMany(FinancialOperation::class, 'currency_id', 'id');
    }
    public function incomes(){
        return $this->hasMany(Income::class, 'currency_id', 'id');
    }
    public function debts(){
        return $this->hasMany(Debt::class, 'currency_id', 'id');
    }
}
