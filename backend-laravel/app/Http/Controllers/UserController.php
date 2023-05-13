<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status_name = DB::table("users_status")
            ->select(
                "id as value",
                "name as label"
            )
            ->get();

        $department_name = DB::table("departments")
            ->select(
                "id as value",
                "name as label"
            )
            ->get();

        return response()->json([
            "users_status" => $status_name,
            "departments" => $department_name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "status_id" => "required",
            "username" => "required|unique:users,username",
            "name" => "required",
            "email" => "required|email",
            "password" => "required|confirmed",
            "department_id" => "required"
        ],[
            "status_id.required" => "Nhập tình trạng",
            "username.required" => "Nhập tên tài khoản",
            "username.unique" => "Tên tài khoản đã tồn tại",
            "name.required" => "Nhập họ và tên",
            "email.required" => "Nhập email",
            "email.email" => "Định dạng email không hợp lệ",
            "password.required" => "Nhập mật khẩu",
            "password.confirmed" => "Mật khẩu không trùng khớp",
            "department_id.required" => "Nhập phòng ban"
        ]);

        // Eloquent ORM
        // C1
        $user = $request->except(["password", "password_confirmation"]);
        $user["password"] = Hash::make($request["password"]);
        User::create($user);
        // C2
        // User::create([
        //     "status_id" => $request["status_id"],
        //     "username" => $request["username"],
        //     "name" => $request["name"],
        //     "email" => $request["email"],
        //     "department_id" => $request["department_id"],
        //     "password" => Hash::make($request["password"])
        // ]);


        // Query Builder
        // DB::table('users')->insert([
        //     'email' => 'kayla@example.com',
        //     'votes' => 0
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);

        $status_name = DB::table("users_status")
            ->select(
                "id as value",
                "name as label"
            )
            ->get();

        $department_name = DB::table("departments")
            ->select(
                "id as value",
                "name as label"
            )
            ->get();

        return response()->json([
            "users" => $users,
            "users_status" => $status_name,
            "departments" => $department_name
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "status_id" => "required",
            "username" => "required|unique:users,username,".$id,
            "name" => "required",
            "email" => "required|email",
            "department_id" => "required"
        ],[
            "status_id.required" => "Nhập tình trạng",

            "username.required" => "Nhập tên tài khoản",
            "username.unique" => "Tên tài khoản đã tồn tại",
            "name.required" => "Nhập họ và tên",
            "email.required" => "Nhập email",
            "email.email" => "Định dạng email không hợp lệ",
            "department_id.required" => "Nhập phòng ban"
        ]);

        User::find($id)->update([
            "status_id" => $request['status_id'],
            "username" => $request['username'],
            "name" => $request['name'],
            "email" => $request['email'],
            "department_id" => $request['department_id']
        ]);

        if($request['change_password'] == true){
            $validated = $request->validate([
                "password" => "required|confirmed",
            ],[
                "password.required" => "Nhập mật khẩu",
                "password.confirmed" => "Mật khẩu không trùng khớp",
            ]);

            User::find($id)->update([
                "password" => Hash::make($request['password']),
                "change_password_at" => NOW()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
