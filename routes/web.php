<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::group(['prefix'=>'Admin'],function(){
    Route::group(['middleware'=>'Admin.guest'],function(){
            Route::get('/',[AdminController::class,'register']);
            Route::post('/register',[AdminController::class,'RegisterSave'])->name('Register');
            Route::get('/login',[AdminController::class,'login'])->name('login');
            Route::post('/authenticate',[AdminController::class,'authenticate'])->name('authenticate');
           
    });
    Route::group(['middleware'=>'Admin.auth'],function(){
      Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    });
});