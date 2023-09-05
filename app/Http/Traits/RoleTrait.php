<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait RoleTrait{
        public function CreateRoleValidator(Array $data){
            $validator = Validator::make($data,[
                'roleName'=>'required|string',
            ]);
            return $validator;
        }
        
        public function UpdateRoleValidator(Array $data){
            $validator = Validator::make($data,[
                'roleName'=>'sometimes|string',
            ]);
            return $validator;
        }
    }