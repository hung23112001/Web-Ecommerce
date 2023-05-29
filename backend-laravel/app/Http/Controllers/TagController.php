<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = DB::table('tag')->get();

        return $tags;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('tag')->insert([
            "name" => $request->name,
            "description" => $request->description,
        ]);

        $check_create = DB::table("tag")->whereName($request->username)->get()->count();

        if($check_create == 1){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::table('tag')->find($id);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $info_tags = DB::table('tag')->find($id);

        return $info_tags;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $info_tags = DB::table('tag')->find($id);

        $info_tags->update($request->all());
        return $info_tags;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tags = DB::table('tag')->find($id);
        $tags->delete();
        
        $check_delete = DB::table("tag")->where('id', $id)->get()->count();

        if($check_delete == 1){
            return false;
        }
        else{
            return true;
        }
    }
}
