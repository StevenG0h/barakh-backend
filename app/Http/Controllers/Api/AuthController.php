<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\userService;
use Illuminate\Contracts\Validation\Validator as ContractsValidationValidator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request){
        $validator = $request->validate([
            "email"=>["required","email","exists:users,email"],
            "password"=>["required"]
        ]);
        $user = User::where("email",$validator['email'])->first();

        if($user && Hash::check($validator['password'], $user->password)){
            $token = $user->createToken("API_Login");
            return response($token,200);
        }else{
            return response([
                "message"=>"invalid login"
            ],402);
        }
    }

    public function register(Request $request, userService $service){
        $user = $service->createUser($request->all());
        if(!$user){
            return response([
                "message"=>"server error"
            ],500);
        }
        return response([
            "data"=>$user
        ],200);
    }

}
