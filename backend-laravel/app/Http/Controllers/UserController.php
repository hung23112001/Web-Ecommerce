<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  

class UserController extends Controller
{
    public function login(Request $request) 
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password ]) ){
            return true;
        }
        else{
            return "Thông tin tài khoản mật khẩu không chính xác, vui lòng thử lại!!";
        }
    }

    public function index()
    {
        $users = User::
            join('departments', 'users.department_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select(
                'users.*', 
                'departments.name as department', 
                'users_status.name as status'
                )
            ->get();

        // return $users;
        return view('users/index', compact('users'))->with('i',(request()->input('page', 1) -1) *5);
    }


    public function create(){
        return view('users/create');
    }


    public function store(Request $request)
    {
        // Eloquent ORM
        // C1
        $user = $request->except(["password", "password_confirmation"]);
        $user["password"] = Hash::make($request["password"]);
        $user["department_id"] = 2;
        $user["status_id"] = 1;

        User::create($user);
        // // C2
        // User::create([
        //     "status_id" => 1,
        //     "department_id" => 2,
        //     "username" => $request["username"],
        //     "email" => $request["email"],
        //     "password" => Hash::make($request["password"])
        // ]);

        // Query Builder
        $check_create = DB::table("users")->whereUsername($request->username)->get()->count();

        if($check_create == 1){
            return true;
        }
        else{
            return "Lỗi tạo tài khoản. Vui lòng thử lại!!";
        }
    }

    public function show(string $id)
    {
        return User::find($id);
    }


    public function edit(string $id)
    {
        $users = User::find($id);
         
        // ...
    }

    public function update(Request $request, string $id)
    {
        User::find($id)->update([
            "avatar" => $request->avatar,

        ]);
    }


    public function destroy(string $id)
    {
        //
    }
}


        // $validated = $request->validate([
        //     "username" => "required|unique:users,username",
        //     "email" => "required|email|unique:users,email",
        //     "password" => "required|confirmed",
        // ],[
        //     "username.required" => "Nhập tên tài khoản",
        //     "username.unique" => "Tên tài khoản đã tồn tại",
        //     "email.required" => "Nhập email",
        //     "email.unique" => "Email đã tồn tại",
        //     "email.email" => "Định dạng email không hợp lệ",
        //     "password.required" => "Nhập mật khẩu",
        //     "password.confirmed" => "Mật khẩu không trùng khớp",
        // ]);