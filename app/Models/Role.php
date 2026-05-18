<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\User;
use App\Admin;
use App\RoleHasPermission;

class Role extends Model
{
    protected $fillable = ['guard_name','name','slug'];

    public $timestamps = true;

    public function permissions()
    {
        //return $this->belongsToMany(Permission::class)->using(RoleHasPermission::class)
         return $this->belongsToMany(Permission::class,'role_has_permissions');
    }

     /**
     * Get all of the users that are assigned this role.
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'model','model_has_roles','role_id','model_id');

    }

    /**
     * Get all of the admins that are assigned this role.
     */
    public function admins()
    {
        return $this->morphedByMany(Admin::class,'model','model_has_roles','role_id','model_id');
    }

    public function getPermIdsAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }


}
