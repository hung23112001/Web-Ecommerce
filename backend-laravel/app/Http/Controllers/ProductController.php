<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->get();
        return response()->json($products);
    }
    public function store(Request $request)
    {
        //
    }
    public function searchByTags(string $id){
        $product = DB::table('products')->where('tag_id', $id)->get();
        return $product;
    }
    public function show(string $id)
    {
        $product = DB::table('products')->find($id);
        return $product;
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
