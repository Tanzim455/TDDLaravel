<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
   
    return view('welcome');
});

Route::get('blog',[BlogController::class,'index'])->name('blog.index');

Route::get('blog/{blog}',[BlogController::class,'show']);

Route::post('blog',[BlogController::class,'store'])->name('blog.store');
Route::get('blog/{blog}/edit',[BlogController::class,'edit'])->name('blog.edit');
Route::delete('blog/{blog}',[BlogController::class,'destroy'])->name('blog.destroy');

Route::patch('blog/{blog}',[BlogController::class,'update'])->name('blog.update');

Route::get('register',[AuthController::class,'register']);

Route::post('register',[AuthController::class,'registeruser'])->name('registeruser');