<?php 
    namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
    use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

    trait AdminTrait{
        public function CreateAdminValidator(Array $data) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['required'],
                'adminNum'=>['required','unique:admins,adminNum'],
                'email'=>['required','email','unique:users,email'],
                'unit_usaha_id'=>['sometimes'],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }

        public function UpdateAdminValidator(Array $data, User $user) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['sometimes'],
                'adminNum'=>['sometimes'],
                'email'=>['sometimes','email'],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }
    }