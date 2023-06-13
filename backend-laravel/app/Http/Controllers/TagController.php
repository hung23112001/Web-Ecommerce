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
        $tags = DB::table('tags')->get();

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
        $query_insert = DB::table('tags')->insert([
            "name" => $request->nameTag,
            "description" => $request->descriptionTag,
        ]);

        return $query_insert;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::table('tags')->find($id);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return DB::table('tag')->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $query_updateTag = DB::table('tags')
        ->where('id', $request->id)
        ->update(["name" => $request->nameTag_new,
                    "description" => $request->descriptionTag_new
                ]);

        return $query_updateTag;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tags = DB::table('tags')->where('id', $id)->delete();

        return $tags;
    }
}

