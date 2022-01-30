<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodRestaurant extends Model
{
    public function Food(){
        return $this->belongsTo(Food::class);
    }
    public function Restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public $timestamps = false;
}
