<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\manageuserController;
use App\Http\Controllers\AddUserController;



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
})->middleware('isLogin')->name('welcome');

Route::post('/login',[LoginController::class,'login'])->name('login');
Route::get('/logout',[LogoutController::class,'index'])->name('logout');

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::get('/info/{id}/date/{date}',[AbsensiController::class,'getInfo'])->middleware('isAdmin')->name('info');
Route::get('/admin',[AdminController::class,'index'])->middleware('isAdmin')->name('admin');
Route::get('/absensi',[AbsensiController::class,'index'])->middleware('isAdmin')->name('absensi');
Route::get('/manage-user',[manageuserController::class,'index'])->middleware('isAdmin')->name('manage');
Route::get('/add-user',[AddUserController::class,'index'])->middleware('isAdmin')->name('add');
Route::post('/upload',[UserController::class,'addUser'])->middleware('isAdmin')->name('upload');


Route::get('/user',[UserController::class,'index'])->middleware('isUser')->name('user');
Route::get('/myabsensi/date/{date}',[AbsensiController::class,'getMyAbsen'])->middleware('isUser')->name('myabsensi');
