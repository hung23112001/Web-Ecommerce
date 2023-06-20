<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class ProductController extends Controller
{
    public function index()
    {
        $product = DB::table('products')
            ->join('tags', 'products.tag_id', '=', 'tags.id')
            ->select('products.*', 'tags.name as tag_name')
            ->where('quantity', '>' , '0')
            ->get();
        return response()->json($product);
    }
    public function getAll()
    {
        $product = DB::table('products')
            ->join('tags', 'products.tag_id', '=', 'tags.id')
            ->select('products.*', 'tags.name as tag_name')
            ->get();
        return response()->json($product);
    }
    public function store(Request $request)
    {
        $product_new = $request->product;
        $query = DB::table('products')->insert([
            'name' => $product_new['name'], 
            'image' => $product_new['image'],
            'quantity' => $product_new['quantity'],
            'price' => $product_new['price'],
            'description' => $product_new['description'],
            'rate' => 5,
            'tag_id' => $product_new['tag_id'],
            'onSale' => $product_new['onSale'],
            'news' => $product_new['news'],
        ]);
        return $query;
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
    public function update(Request $request)
    {
        $query = DB::table('products')
        ->where('id', $request->id)
        ->update([
            "name" => $request->name,
            "image" => $request->image,
            "quantity" => $request->quantity,
            "price" => $request->price,
            "description" => $request->description,
            "tag_id" => $request->tag_id,
            "onSale" => $request->onSale,
            "news" => $request->news,
        ]);

        return $query;
    }
    public function destroy(string $id)
    {
        $query_delete = DB::table('products')->where('id', $id)->delete();
        return $query_delete;
    }
}
