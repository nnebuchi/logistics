<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Interfaces\RoleInterface;

class RoleService implements RoleInterface
{
    public function allRoles()
    {
        $roles = Role::latest()->get();
        return $roles;
    }

    public function createRole($name, $description = null){
        $role = new Role();
        $role->name = $name;
        $role->description = $description;
        $role->save();
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        //detach the role from all users before deleting
        $role->users()->each(function($user) use($role) {
            $user->roles()->detach($role);
        });

        //detach all permissions that come with the role also
        $role->permissions()->each(function($permission) use($role) {
            $permission->roles()->detach($role);
            $permission->delete();
        });

        $role->delete();
    }

    public function assignRole($user_id, $role_id)
    {
        $user = User::find($user_id);
        $role = Role::find($role_id);
        $user->roles()->attach($role);
    }

    public function detachRole($user_id, $role_id)
    {
        $user = User::find($user_id);
        $role = Role::find($role_id);
        $user->roles()->detach($role);
    }
}