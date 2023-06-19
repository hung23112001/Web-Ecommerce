<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class CartController extends Controller
{
    public function index()
    {
        return DB::table('carts')->get();
    }

    public function store(Request $request)
    {
        return DB::table('carts')->insert([
            'quantity' => $request->quantity, 
            'user_id' => $request->user_id,
            'product_id' => $request->user_id,
            'created_at' => now(),
        ]);
    }

    public function show(string $id)
    {
        return DB::table('carts')->find($id);
    }

    public function update(Request $request)
    {
        return DB::table('carts')
        ->where('id', $request->id)
        ->update([
            'quantity' => $request->quantity, 
            'user_id' => $request->user_id,
            'product_id' => $request->user_id,
            'updated_at' => now(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $query_delete = DB::table('carts')->where('id', $id)->delete();
        return $query_delete;
    }
}
