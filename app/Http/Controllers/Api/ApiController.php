<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    //for resgister Post API(Form Data)
    public function register(Request $request){
         // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        // User Model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);

    }

    //Login API (POST Form Data)
    public function login(Request $request){
        $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);

        //Request validated the JWt Auth
        $token=JWTAuth::attempt([
            "email"=>$request->email,
            "password"=>$request->password
        ]);
        if(!empty($token)){
            return response()->json([
                "status"=>true,
                "message"=>"User Logged In successfully",
                "token"=>$token
            ]);
        }
        return response()->json([
                "status"=>False,
                "message"=>"Invalid Details Provided"
            ]);

    }

    //GET API Profile
    public function profile(){
        $userData=auth()->user();
        return response()->json([
            "status"=>true,
            "message"=>"Profile Fetched",
            "data"=>$userData
        ]);

    }

    //Refresh Token API (GET)
    public function refreshToken(){
        $newToken=auth()->refresh();
        return response()->json([
            "status"=>true,
            "message"=>"New Token Generated",
            "token"=>$newToken
        ]);
    }

    //LogOut API (GET)
    public function logout(){
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);

    }
}
