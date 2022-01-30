<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrinkRestaurant extends Model
{
    public function Drink(){
        return $this->belongsTo(Drink::class);
    }
    public function Restaurant(){
        return $this->belongsTo(Restaurant::class);
    }


    public $timestamps = false;
}
