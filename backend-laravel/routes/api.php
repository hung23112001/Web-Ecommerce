<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// API USER
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/register', [UserController::class, 'store']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/search/{id}', [UserController::class, 'show']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::put('/users/update/{id}', [UserController::class, 'update']);

// PRODUCT
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search/{id}', [ProductController::class, 'show']);

// TAG
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/search/{id}', [TagController::class, 'show']);
Route::get('/tags/edit/{id}', [TagController::class, 'edit']);
Route::put('/tags/update/{id}', [TagController::class, 'update']);


// DEPARTMENTS
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/departments/search/{id}', [DepartmentController::class, 'show']);

// CATEGORY
Route::get('/categories', [CategoryController::class, 'index']);