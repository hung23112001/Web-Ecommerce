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

            // $request->session()->put('usersID', $id);
            $users = DB::table('users')->find($id);
            // $department_id = DB::table("users")->where('id', $id)->select('department_id')->get();

            // return redirect()->route('users.index')->with('message',"Bạn đã đăng nhập thành công");
            return [
                'users' => $users,
                'message'=> true,
            ];
        }
        else{
            $message = false;
            // return redirect()->route('auth.login')->with('message',"Thông tin tài khoản mật khẩu không chính xác");
            return $message;
        }
        
        // return $request;
    }

    public function logout(Request $request) {
        // Remove only session
        // $request->session()->forget('usersID');

        // Remove all session
        $request->session()->flush();
        Auth::logout();
        return true;
        // return redirect()->route('auth.login')->with('message',"Bạn đã đăng xuất khỏi hệ thống");
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
        // $users = DB::table('users')->get();

        return $users;
        // return view('users/index', compact('users'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function create()
    {
        return view('auth/register');
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
            // "username" => $request["username"],
            "email" => $request["email"],
            "password" => Hash::make($request["password"])
        ]);

        // $get = DB::table("users")->whereUsername($request->username)->get()->count();

        

        $check_create = DB::table("users")->whereUsername($request->username)->get()->count();

        if($check_create == 1){
            // return redirect()->route('auth.login')->with('message',"Đăng ký tài khoản thành công");
            return true;
        }
        else{
            return false;
            // return redirect()->route('users.create')->with('error',"Lỗi đăng ký, vui lòng thử lại");
        }
    }

    
    public function show(string $id)
    {
        $users = DB::table('users')->find($id);
        return $users;
        // return view('users/info', compact('users'))->with('message',"Thông tin tài khoản!");
    }


    public function edit(string $id)
    {
        $users = DB::table('users')->find($id);
         
        $departments = DB::table('departments')->get();
        $users_status = DB::table('users_status')->get();
        
        // return view('users/edit', compact('users', 'departments', 'users_status'));
        return $users;
    }

    public function update(Request $request, string $id)
    {
        $users = DB::table('users')->find($id);
        $request["password"] = Hash::make($request["password"]);

        $users->update($request->all());

        // return redirect()->route('users.index')->with('message', "Cập nhật thành công");
        return $users;
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
        // return redirect()->route('users.index')->with('message','Xóa tài khoản thành công');
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