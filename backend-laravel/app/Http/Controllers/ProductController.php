<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class ProductController extends Controller
{
    public function index()
    {
        $product = DB::table('products')->get();

        return response()->json($product);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function searchByTags(string $id){
        $users = DB::table('products')->where('tag_id', $id)->get();
        return $users;
    }
    public function show(string $id)
    {
        $users = DB::table('products')->find($id);
       
        // $users = DB::table('products')->where('id_tag', $id)->get();
        return $users;
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
