<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleGroupPermission extends Model
{
    public function Permission(){
        return $this->belongsTo(Permission::class);
    }
    public function RoleGroup(){
        return $this->belongsTo(RoleGroup::class);
    }

    public $timestamps = false;
}
