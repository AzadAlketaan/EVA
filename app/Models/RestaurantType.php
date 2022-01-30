<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model
{
    public function Restaurant()
    {
        return $this->hasMany(Restaurant::class);
    }
}
