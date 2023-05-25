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
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password ]) ){
            $id = Auth::user()->id; //or Auth::id();
            $request->session()->put('usersID', $id);
            return redirect()->route('users.index')->with('message',"Bạn đã đăng nhập thành công");
        }
        else{
            return redirect()->route('auth.login')->with('message',"Thông tin tài khoản mật khẩu không chính xác");
        }
    }

    public function logout(Request $request) {
        // Remove only session
        // $request->session()->forget('usersID');
        // Remove all session
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('auth.login')->with('message',"Bạn đã đăng xuất khỏi hệ thống");
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
        // $user = $request->except(["password", "password_confirmation"]);
        $user = $request->except(["password"]);
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
            return redirect()->route('users.index')->with('message',"Đăng ký tài khoản thành công");
        }
        else{
            return redirect()->route('users.create')->with('error',"Lỗi đăng ký, vui lòng thử lại");
        }
    }

    
    public function show(string $id)
    {
        $users = User::find($id);
        return view('users/info', compact('users'))->with('message',"Thông tin tài khoản!");
    }


    public function edit(string $id)
    {
        $users = User::find($id);
         
        $departments = DB::table('departments')->get();
        $users_status = DB::table('users_status')->get();
        
        return view('users/edit', compact('users', 'departments', 'users_status'));
        // return $departments;
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request["password"] = Hash::make($request["password"]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('message', "Cập nhật thành công");
    }


    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('message','Xóa tài khoản thành công');
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