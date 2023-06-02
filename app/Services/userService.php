<?php 
    namespace App\Services;

use App\Http\Traits\AdminTrait;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

    class UserService{
        use AdminTrait;

        public function createUser(Array $data): User{
            $validation =  $this->CreateAdminValidator($data)->validate();
            $user = new User;
            $admin = new Admin();
            
            $user->email = $validation['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            $admin->adminName = $validation['adminName'];
            $admin->adminNum = $validation['adminNum'];
            $admin->adminLevel = '1';
            $admin->adminId = $user->id;
            $admin->save();
            
            return $user;
        }
    }
?>