<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return view('auth/login');
})->name('auth.login');
// Route::view("/{any}", "app")->where("any", ".*");


// API USER
Route::resource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::get('/logout', [UserController::class, 'logout'])->name('users.logout');