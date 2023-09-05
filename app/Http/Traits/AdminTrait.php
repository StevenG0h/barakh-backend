<?php 
    namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
    use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

    trait AdminTrait{
        public function CreateAdminValidator(Array $data) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['required','unique:admins,adminName'],
                'adminNum'=>['required','unique:admins,adminNum'],
                'email'=>['required','email','unique:users,email'],
                'unit_usaha_id'=>['required'],
                'role_id'=>['required'],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }

        public function UpdateAdminValidator(Array $data, User $user, Admin $admin) : ValidationValidator{
            $validator = Validator::make($data,[
                'adminName'=>['sometimes',Rule::unique('admins', 'adminName')->ignore($admin->id)],
                'adminNum'=>['sometimes',Rule::unique('admins', 'adminNum')->ignore($admin->id)],
                'email'=>['sometimes',Rule::unique('users', 'email')->ignore($user->id)],
                'password'=>['confirmed','min:8']
            ]);
            return $validator;
        }
    }