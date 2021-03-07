<?php

namespace App\Traits\Users;

use App\Models\Role;

trait UserRolesTrait
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function canAccessSpecificArea( array $list_of_roles )
    {
        return $this->roles()->whereIn( 'name' , $list_of_roles )->count();
    }

}
