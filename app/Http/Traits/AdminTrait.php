<?php 
    namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
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
    }