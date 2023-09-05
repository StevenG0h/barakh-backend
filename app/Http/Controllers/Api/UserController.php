<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::with(['admins.role','admins.unitUsaha'])->whereRelation('admins','isActive',1)->paginate(25);
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
}
