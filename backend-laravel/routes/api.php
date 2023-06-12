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
Route::post('/users/logout', [UserController::class, 'logout']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/users/search/{id}', [UserController::class, 'show']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::put('/users/update', [UserController::class, 'update']);
Route::put('/users/changePassword', [UserController::class, 'changePassword']);


// PRODUCT
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/searchByID/{id}', [ProductController::class, 'show']);
Route::get('/products/searchTag/{id}', [ProductController::class, 'searchByTags']);

// TAG
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/search/{id}', [TagController::class, 'show']);
Route::post('/tags/add', [TagController::class, 'store']);
Route::put('/tags/update', [TagController::class, 'update']);
Route::delete('/tags/delete/{id}', [TagController::class, 'destroy']);


// DEPARTMENTS
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/departments/search/{id}', [DepartmentController::class, 'show']);

// CATEGORY
Route::get('/categories', [CategoryController::class, 'index']);


// ME
// Route::get('/me', [UserController::class, 'me']);

