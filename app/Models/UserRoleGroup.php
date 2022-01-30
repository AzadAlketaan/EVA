<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleGroup extends Model
{
    public function User(){
        return $this->belongsTo(User::class);
    } 
    public function RoleGroup(){
        return $this->belongsTo(RoleGroup::class);
    } 

    public $timestamps = false;
}
