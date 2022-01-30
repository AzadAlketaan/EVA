<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    public function Food(){
        return $this->hasMany(Food::class);
    }
}
