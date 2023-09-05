<?php 
    namespace App\Services;

use App\Http\Traits\RoleTrait;
use App\Models\role;

    class RoleService{
        use RoleTrait;

        public function createRole(Array $data): role{
            $validation =  $this->CreateRoleValidator($data)->validate();
            $Role = role::create($validation);
            
            return $Role;
        }
        
        public function updateRole($id,Array $data): role{
            $validation =  $this->UpdateRoleValidator($data)->validate();
            $Role = role::findOrFail($id);
            $Role->update($validation);
            return $Role;
        }

        public function deleteRole($id): role{
            $Role = role::findOrFail($id);
            $Role->delete();
            return $Role;
        }
    }
?>