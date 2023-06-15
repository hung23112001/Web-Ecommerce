<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        $user = DB::table('users')->insert([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => 2, 
            "username" => $request->username,
            "status" => 0,
        ]);
        return $user;
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details']);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' =>  $user
        ]);
    }
    public function logout(Request $request) 
    {
        Auth::logout();
        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
