<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $table = "permission";

    protected $fillable = [
        'name', 'slug',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
