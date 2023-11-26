<?php 
    namespace App\Services;

use App\Http\Traits\AdminTrait;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

    class UserService{
        use AdminTrait;

        public function createUser(Array $data): User{
                $user = new User;
                $admin = new Admin();
                $validation =  $this->CreateAdminValidator($data)->validate();
                $user->email = $validation['email'];
                $user->password = Hash::make($data['password']);
                $user->save();
                $admin->adminName = $validation['adminName'];
                $admin->adminNum = $validation['adminNum'];
                $admin->adminLevel = '0';
                $admin->user_id = $user->id;
                $admin->unit_usaha_id = $data['unit_usaha_id'];
                $admin->role_id = $data['role_id'];
                $admin->save();
                
                return $user;
            
        }

        public function updateUser($user,Array $data){
            $user = User::find($user);
            $admin = Admin::where('user_id',$user->id)->firstOrFail();
            $validation =  $this->UpdateAdminValidator($data, $user, $admin)->validate();
            if(!empty($validation['password'])){
                $user->password = Hash::make($validation['password']);
            }
            $user->email = $validation['email'];
            $user->save();

            $admin->adminName = $validation['adminName'];
            $admin->adminNum = $validation['adminNum'];
            $admin->unit_usaha_id = $data['unit_usaha_id'];
            $admin->role_id = $data['role_id'];
            $admin->save();
            
            return $user;
        }
        
        public function destroy($user){
            $user = User::findOrFail($user);
            $admin = Admin::where('user_id',$user->id)->firstOrFail();
            if($admin->isActive == 0){
                $admin->isActive=1;
                $admin->save();
                return true;
            }
            $admin->deleted_at = Carbon::now();
            $admin->isActive=0;
            $admin->save();
            return true;
        }

        public function destroyPermanent($user){
            $user = User::findOrFail($user);
            $admin = Admin::where('user_id',$user->id)->firstOrFail();
            $admin->delete();
            $user->delete();
            return true;
        }
    }
?>