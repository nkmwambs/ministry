<?php

namespace App\Entities;

// use CodeIgniter\Database\Exceptions\DataException;
// use CodeIgniter\I18n\Time;
// use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\Traits\HasAccessTokens;
use CodeIgniter\Shield\Authentication\Traits\HasHmacTokens;
use CodeIgniter\Shield\Authorization\Traits\Authorizable;
// use CodeIgniter\Shield\Models\LoginModel;
// use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Traits\Activatable;
use CodeIgniter\Shield\Traits\Bannable;
use CodeIgniter\Shield\Traits\Resettable;


class User extends \CodeIgniter\Shield\Entities\User
{
    use Authorizable;
    use HasAccessTokens;
    use HasHmacTokens;
    use Resettable;
    use Activatable;
    use Bannable;

    // protected $datamap = [];
    // protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    // protected $casts   = [];


    public function canDo(string ...$permissions){
        // Get user's permissions and store in cache
        $this->populatePermissions();

        // Check the groups the user belongs to
        $this->populateGroups();

        foreach ($permissions as $permission) {
            // Permission must contain a scope and action
            if (strpos($permission, '.') === false) {
                throw new  \CodeIgniter\Shield\Exceptions\LogicException(
                    'A permission must be a string consisting of a scope and action, like `users.create`.'
                    . ' Invalid permission: ' . $permission
                );
            }

            $permission = strtolower($permission);

            // Check user's permissions
            if (in_array($permission, $this->permissionsCache, true)) {
                return true;
            }

            if (count($this->groupCache) === 0) {
                return false;
            }

            $matrix = []; // setting('AuthGroups.matrix');

            $roleModel = new \App\Models\RolesModel();
            $roles = $roleModel->select('name as group, permissions')->findAll();

            foreach($roles as $role){
                $matrix[$role['group']] = json_decode($role['permissions']);
            }

            foreach ($this->groupCache as $group) {
                // Check exact match
                $matrix_group = isset($matrix[$group]) ? $this->updatePermissionsByStrength($matrix[$group]) : [];

                if (!empty($matrix_group) && in_array($permission, $matrix_group, true)) {
                    return true;
                }

                // Check wildcard match
                $check = substr($permission, 0, strpos($permission, '.')) . '.*';
                if (isset($matrix[$group]) && in_array($check, $matrix[$group], true)) {
                    return true;
                }
            }
        }

        return false;
   }

   function updatePermissionsByStrength($permissions){
       $updatedPermissions = [];
       $labelOrder = [1 => 'delete', 2 => 'update', 3 => 'create', 4 => 'read'];

       $newOrder = [];

       foreach($permissions as $permission){
           $permissionArray = explode(".", $permission);
           $newOrder[$permissionArray[0]][] = $permissionArray[1];
       }

       foreach($newOrder as $feature => $permission_labels){
           $keyOrder = 4;
           foreach($permission_labels as $ourLabel){
               $searchedKey = array_search($ourLabel,$labelOrder);
               if($searchedKey < $keyOrder){
                   $keyOrder = $searchedKey;
               }   
           }

           foreach($labelOrder  as $labelKey => $labelOrderElement){
               if($labelKey < $keyOrder){
                   continue;
               }
               $updatedPermissions[] = $feature.".".$labelOrderElement;
           }
       }

       return $updatedPermissions;
   }
}
