<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrinkType extends Model
{
    public function Drink(){
        return $this->hasMany(Drink::class);
    }
}
