<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;

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


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/search/{id}', [UserController::class, 'show']);
    Route::get('/edit/{id}', [UserController::class, 'show']);
    Route::put('/update', [UserController::class, 'update']);
    Route::put('/changePassword', [UserController::class, 'changePassword']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/searchByID/{id}', [ProductController::class, 'show']);
    Route::get('/searchTag/{id}', [ProductController::class, 'searchByTags']);
});

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::get('/search/{id}', [TagController::class, 'show']);
    Route::post('/addTags', [TagController::class, 'store']);
    Route::put('/update', [TagController::class, 'update']);
    Route::delete('/delete/{id}', [TagController::class, 'destroy']);
});


