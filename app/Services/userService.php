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
            $admin->adminLevel = '0';
            $admin->user_id = $user->id;
            $admin->save();
            
            return $user;
        }
        public function updateUser($user,Array $data): User{
            $user = User::findOrFail($user);
            $validation =  $this->UpdateAdminValidator($data, $user)->validate();
            $admin = Admin::where('user_id',$user->id)->firstOrFail();
            if(!empty($validation['password'])){
                $user->password = Hash::make($validation['password']);
            }
            $user->email = $validation['email'];
            $user->save();

            $admin->adminName = $validation['adminName'];
            $admin->adminNum = $validation['adminNum'];
            $admin->user_id = $user->id;
            $admin->save();
            
            return $user;
        }
        
        public function destroy($user){
            $user = User::findOrFail($user);
            $admin = Admin::where('user_id',$user->id)->firstOrFail();
            $admin->destroy($admin->id);
            $user->destroy($user->id);
        }
    }
?>