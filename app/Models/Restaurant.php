<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function UserRestaurant(){
        return $this->hasMany(UserRestaurant::class);
    }
    public function Reservation(){
        return $this->hasMany(Reservation::class);
    }
    public function Order(){
        return $this->hasMany(Order::class);
    }
    public function Evaluation(){
        return $this->hasMany(Evaluation::class);
    }
    public function DrinkRestaurant(){
        return $this->hasMany(DrinkRestaurant::class);
    }
    public function FoodRestaurant(){
        return $this->hasMany(FoodRestaurant::class);
    }
    public function Address(){
        return $this->hasMany(Address::class);
    }
    public function RestaurantType(){
        return $this->belongsTo(RestaurantType::class);
    }
}
