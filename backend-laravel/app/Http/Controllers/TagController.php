<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class TagController extends Controller
{
    public function index()
    {
        $tags = DB::table('tags')->get();
        return $tags;
    }
    public function store(Request $request)
    {
        $query = DB::table('tags')->insert(['name' => $request->nameTag, 'status' => 1]);
        return $query;
    }
    public function show(string $id)
    {
        return DB::table('tags')->find($id);
    }
    public function update(Request $request)
    {
        $query = DB::table('tags')
        ->where('id', $request->id)
        ->update(["name" => $request->nameTag]);

        return $query;
    }
    public function destroy(string $id)
    {
        $query_delete = DB::table('tags')->where('id', $id)->delete();
        return $query_delete;
    }
}

