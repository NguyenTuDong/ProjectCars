<?php
namespace App;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

   public function roles() {
      return $this->belongsToMany(Role::class,'admins_roles');

   }

   public function permissions() {
      return $this->belongsToMany(Permission::class,'admins_permissions');

   }

   public function hasRole(...$roles) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }
     
    public function hasPermission($slug) {
        return (bool) $this->permissions->where('slug', $slug)->count() 
        || $this->where('id', $this->id)->whereHas('roles.permissions', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->count();
    }

    protected function getAllPermissions($permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    public function givePermissionsTo(...$permissions) {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
           return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(...$permissions) {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }
}