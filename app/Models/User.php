<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name' , 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
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
    public function UserRoleGroup(){
        return $this->hasMany(UserRoleGroup::class);
    }
    public function Address(){
        return $this->hasMany(Address::class);
    }
}
