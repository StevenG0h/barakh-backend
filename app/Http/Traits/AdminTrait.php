<?php 
    namespace App\Http\Traits;

    use Illuminate\Contracts\Validation\Validator as ValidationValidator;
    use Illuminate\Support\Facades\Validator;

    trait AdminTrait{
        public function CreateAdminValidator(Array $data) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['required'],
                'adminNum'=>['required','unique:admins,adminNum'],
                'email'=>['required','email','unique:users,email'],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }
        public function UpdateAdminValidator(Array $data) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['sometimes'],
                'adminNum'=>['sometimes','unique:admins,adminNum'],
                'email'=>['sometimes','email','unique:users,email'],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }
    }