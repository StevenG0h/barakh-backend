<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
	if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $user = User::with(['admins.role','admins.unitUsaha'])->where('id',$user->user_id)->whereRelation('admins','isActive',1)->orderBy('updated_at','desc')->paginate(25);
                return response($user,200);
            }
        }
        $user = User::with(['admins.role','admins.unitUsaha'])->whereRelation('admins','isActive',1)->orderBy('updated_at','desc')->paginate(25);
        return response($user,200);
    }
    
    public function show($user){
        $user = User::find($user)->with(['admins'])->whereRelation('admins','isActive',1)->first();
        return response($user,200);
    }
    
    public function getDeleted(){
        $user = User::with(['admins.role','admins.unitUsaha'])->whereRelation('admins','isActive',0)->paginate(25);
        return response($user,200);
    }

    public function edit($user, Request $request, UserService $userService){
        $user = $userService->updateUser($user,$request->all());
        return $user;
    }
    
    public function destroy($user, UserService $userService){
        $user = $userService->destroy($user);
        return $user;
    }

    public function destroyPermanent($user, UserService $userService){
        $user = $userService->destroyPermanent($user);
        return $user;
    }
}
