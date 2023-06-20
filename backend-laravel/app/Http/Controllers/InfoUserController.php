<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class InfoUserController extends Controller
{
    public function show(string $id)
    {
        $info_user = DB::table('info_users')
            ->where('info_users.user_id', $id)
            ->join('users', 'info_users.user_id', 'users.id')
            ->select('users.*', 'info_users.*', 'info_users.id as id_info')
            ->first();
        return $info_user;
    }
    public function update(Request $request)
    {
        $query = DB::table('info_users')
        ->where('user_id', $request->id)
        ->update(["telephone" => $request->phoneNumber, 'address' => $request->address]);

        return $query;
    }
}
