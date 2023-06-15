<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('id', 'asc')->get();
        return $users;
    }
    public function show(string $id)
    {
        $user = DB::table('users')->find($id);
        return $user;
    }
    public function update(Request $request)
    {

    }
    public function changePassword(Request $request)
    {
        $userCurrent = DB::table('users')->find($request->id);

        if(Auth::attempt(['email' => $userCurrent->email, 'password' => $request->currentPass ])){
            $userCurrent = DB::table('users')
            ->where('id', $request->id)
            ->update(["password" => Hash::make($request->newPass)]);
            if($userCurrent > 0){
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
        $user = DB::table('users')->find($id);
        $user->delete();
        $checkQuery = DB::table("users")->where('id', $id)->get()->count();
        if($checkQuery > 0){
            return false;
        }
        else{
            return true;
        }
    }
}
