<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function RoleGroupPermission(){
        return $this->hasMany(RoleGroupPermission::class);
    }
}
