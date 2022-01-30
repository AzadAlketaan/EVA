<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    public function UserRoleGroup(){
        return $this->hasMany(UserRoleGroup::class);
    }
    public function RoleGroupPermission(){
        return $this->hasMany(RoleGroupPermission::class);
    }
}
