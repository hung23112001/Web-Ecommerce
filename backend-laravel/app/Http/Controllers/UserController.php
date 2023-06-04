<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password ]) ){
            $id = Auth::user()->id;
            $users = DB::table('users')->find($id);

            // $request->session()->put('usersID', $id);
            // $department_id = DB::table("users")->where('id', $id)->select('department_id')->get();
            return [
                'users' => $users,
                'message'=> true,
            ];
            // return response()->json(['user' => $users, 'message'=> true]);
        }
        else{
            $message = false;
            return $message;
        }
    }

    public function logout(Request $request) 
    {
        // Remove only session
        // $request->session()->forget('usersID');

        // Remove all session
        // $request->session()->flush();
        Auth::logout();
        return [
            'message'=> 'Đăng xuất thành công',
        ];
    }

    public function index()
    {
        // $users = DB::table('users')->get();

        $users = DB::table('users')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select(
                'users.*',
                'departments.name as department',
                'users_status.name as status'
                )
            ->orderBy('id', 'asc')
            ->get();

        // $users = DB::table('users')
        // ->leftJoin('users_status', 'users.status_id', '=', 'users_status.id')
        //     // ->join('departments', 'users.department_id', '=', 'departments.id')
        //     // ->join('users_status', 'users.status_id', '=', 'users_status.id')
            // ->select(
            //     'users.*',
            //     'departments.name as department',
            //     'users_status.name as status'
            //     )
        //             )
        //     ->get();

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
        // dd($request->all());

        // Eloquent ORM
        // C1
        // $user = $request->except(["password", "password_confirmation"]);
        // $user = $request->except(["password"]);
        // $user["password"] = Hash::make($request["password"]);
        // $user["department_id"] = 2;
        // $user["status_id"] = 1;
        // User::create($user);
        // C2
        // // User::create([
        // //     "status_id" => 1,
        // //     "department_id" => 2,
        // //     "username" => $request["username"],
        // //     "email" => $request["email"],
        // //     "password" => Hash::make($request["password"])
        // // ]);

        // Query Builder
        DB::table('users')->insert([
            "status_id" => 1,
            "department_id" => 2,
            "email" => $request->email,
            "password" => Hash::make($request["password"])
        ]);

        // $get = DB::table("users")->whereUsername($request->username)->get()->count();

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
        $users = DB::table('users')->find($id);

        $departments = DB::table('departments')->get();
        $users_status = DB::table('users_status')->get();

        return [ $users, $departments, $users_status ];
    }

    public function update(Request $request)
    {
        $users = DB::table('users')
        ->where('id', $request->id)
        ->update(["department_id" => $request->department_id,
                    "status_id" => $request->status_id
                ]);

        if($users > 0){
            return true;
        }
        else{
            return false;
        }
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
        // return $request;
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
