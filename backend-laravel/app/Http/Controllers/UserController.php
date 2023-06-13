<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request) {
        $user = DB::table('users')->insert([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => 1, 
            "username" => $request->username,
            "status" => 0,
        ]);
        if($user == 1){
            return true;
        }
        return false;

    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
            'message' => 'Invalid login details'
                    ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' =>  $user
            ]
        ], 200);
    }
    public function logout(Request $request) 
    {
        Auth::logout();
        return [
            'message'=> 'Đăng xuất thành công',
        ];
    }

    public function index()
    {
        $users = DB::table('users')
            ->orderBy('id', 'asc')
            ->get();

        return $users;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // AVATAR
        // if($request->has('avatar')){
        //     $file = $request->avatar;
        //     $file_name = $file->getClientoriginalName();
        //     // dd($file_name);
        //     $file->move(public_path('uploads'), $file_name);
        // }

        // Query Builder
        DB::table('users')->insert([
            "status" => 1,
            "role" => 2,
            "email" => $request->email,
            "password" => Hash::make($request["password"])
        ]);

        $check_create = DB::table("users")->whereUsername($request->username)->get()->count();

        if($check_create == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function show(string $id)
    {
        $users = DB::table('users')->find($id);
        return $users;
    }
    public function edit(string $id)
    {

    }

    public function update(Request $request)
    {

    }

    public function changePassword(Request $request)
    {
        $usersCurrent = DB::table('users')->find($request->id);

        if(Auth::attempt(['email' => $usersCurrent->email, 'password' => $request->currentPass ])){
            $usersCurrent = DB::table('users')
            ->where('id', $request->id)
            ->update(["password" => Hash::make($request->newPass)]);
            if($usersCurrent > 0){
                return [
                    'message'=>'Đổi mật khẩu thành công',
                    'result'=>true
                ];
            }
            else{
                return [
                    'message'=>'Lỗi cập nhật vui lòng thử lại',
                    'result'=>false
                ];
            }
        }
        else{
            return [
                'message'=>'Mật khẩu nhập vào không chính xác',
                'result'=>false
            ];
        }
    }
    public function destroy(string $id)
    {
        $users = DB::table('users')->find($id);
        $users->delete();

        $check_delete = DB::table("users")->where('id', $id)->get()->count();

        if($check_delete == 1){
            return false;
        }
        else{
            return true;
        }
    }
}
