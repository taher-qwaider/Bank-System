<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    public function sendUser(){
        return $this->belongsTo(User::class, 'sender_user_id', 'id');
    }
    public function reciveUser(){
        return $this->belongsTo(User::class, 'receiver_user_id', 'id');
    }
}
