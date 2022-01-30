<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
