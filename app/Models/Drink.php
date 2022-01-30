<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    public function DrinkType(){
        return $this->belongsTo(DrinkType::class);
    } 
    public function DrinkRestaurant(){
        return $this->hasMany(DrinkRestaurant::class);
    }
}
