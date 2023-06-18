<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccount;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        $token = Str::random(64);
        $query_insert = DB::table('users')->insert([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => User::ROLE_USER, 
            "username" => $request->username,
            "status" => User::STATUS_NO_ACTIVE,
            'token_verify_email' => $token
        ]);
        if ($query_insert) {
            $dataSendMail = ['title' => "Hi ".$request['username']." !",'token' => $token,];
            Mail::to($request->email)->send(new VerifyAccount($dataSendMail)); 
            return true;
        }
        return false;
    }
    public function verifyEmail(string $token)
    {
        $user = DB::table('users')->where('token_verify_email', $token)->where('email_verified_at', null)->first();
        if ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['email_verified_at' => now(), 'status' => User::STATUS_ACTIVE]);
            return "Kích hoạt tài khoản thành công. Click vào đường dẫn này để đăng nhập: http://localhost:3000/users/login";
        }
        return "Kích hoạt tài khoản thất bại. Vui lòng thử lại";
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'status' => User::STATUS_ACTIVE])) {
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' =>  $user,
                'result' => true,
                'message' => 'Đăng nhập thành công'
            ]);
        }
        return response()->json([
            'message' => 'Thông tin tài khoản, mật khẩu không chính xác. Hoặc tài khoản của bạn chưa được xác thực.',
            'result' => false
        ]);
    }
    public function logout(Request $request) 
    {
        Auth::logout();
        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
