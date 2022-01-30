<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public function FoodType()
    {
        return $this->belongsTo(FoodType::class);
    }
    public function FoodRestaurant()
    {
        return $this->hasMany(FoodRestaurant::class);
    }
}
