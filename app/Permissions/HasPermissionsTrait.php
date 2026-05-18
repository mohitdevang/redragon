<?php
namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {


	public function roles()
    {
        return $this->morphToMany(Role::class,'model','model_has_roles','model_id','role_id');

    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class,'model','model_has_permissions','model_id','permission_id');

    }

	public function roleHasPermission($guardName,$permission) {

 		$permission_exists = Permission::where([['guard_name',$guardName],['name', $permission]])->first();

 		if($permission_exists){

 			$roles = $this->roles;

 			foreach ($roles as $key => $role) {

 				$role_has_permissions = $role->permissions()->pluck('name')->toArray();


				  if(in_array($permission,$role_has_permissions)) {
				      
				      return true;

				  }

 			}

 			return false;
			
		}

		return false;
    }

    public function userHasPermission($guardName,$permission) {

 		$permission_exists = Permission::where([['guard_name',$guardName],['name', $permission]])->first();

 		if($permission_exists){

 			$permissions = $this->permissions;

 			foreach ($permissions as $key => $per) {

 				$user_has_permissions = $this->permissions()->pluck('name')->toArray();

				  if(in_array($permission,$user_has_permissions)) {
				      
				      return true;

				  }

 			}

 			return false;
			
		}

		return false;
    }


    public function hasPermission($guardName,$permission){

    	$result  = $this->roleHasPermission($guardName,$permission);
    	$result2  = $this->userHasPermission($guardName,$permission);

    	if($result || $result2){

    		return true;

    	}else{

    		return false;
    		
    	}

    }
   

	
}