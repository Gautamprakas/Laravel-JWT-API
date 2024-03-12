<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    public function login(){

    }

    //GET API Profile
    public function profile(){

    }

    //Refresh Token API (GET)
    public function refreshToken(){

    }

    //LogOut API (GET)
    public function logout(){

    }
}
