<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Admin;
use App\User;


class Permission extends Model
{
    protected $fillable = ['guard_name','name','slug','description'];

    public $timestamps = true;

    public function roles()
    {
        //return $this->belongsToMany(Role::class)->using(RoleHasPermission::class)->withPivot(['created_by','updated_by']);
        return $this->belongsToMany(Role::class,'role_has_permissions');
    }

    /**
     * Get all of the users that are assigned this permission.
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'model','model_has_permissions','permission_id','model_id');
    }

    /**
     * Get all of the admins that are assigned this permission.
     */
    public function admins()
    {
        return $this->morphedByMany(Admin::class,'model','model_has_permissions','permission_id','model_id');
    }

    
}
