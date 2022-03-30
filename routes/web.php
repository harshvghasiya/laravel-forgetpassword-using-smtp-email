<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>['guest']], function(){

Route::any('/login',[App\Http\Controllers\AdminController::class, 'loginForm'])->name('loginForm');
Route::any('/register',[App\Http\Controllers\AdminController::class, 'registerForm'])->name('registerForm');
Route::any('/registerSubmit',[App\Http\Controllers\AdminController::class, 'register'])->name('register');
Route::any('/loginSubmit',[App\Http\Controllers\AdminController::class, 'login'])->name('login');
});

Route::any('/forgetpassword',[App\Http\Controllers\AdminController::class, 'forgetpasswordForm'])->name('forgetpasswordForm');
Route::any('/forgetpasswordSubmit',[App\Http\Controllers\AdminController::class, 'forgetpassword'])->name('forgetpassword');


Route::any('reset/{token}',[App\Http\Controllers\AdminController::class, 'resetForm'])->name('resetForm');
Route::any('resetPasswordSubmit',[App\Http\Controllers\AdminController::class, 'resetPasswordSubmit'])->name('resetPasswordSubmit');

Route::group(['middleware'=>['auth']], function(){

Route::any('/dashboard',[App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
Route::any('/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

});