<?php

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

Route::get('blog/{id}',[BlogController::class,'show']);

Route::post('blog',[BlogController::class,'store'])->name('blog.store');
Route::get('blog/{id}/edit',[BlogController::class,'edit'])->name('blog.edit');
Route::delete('blog/{id}',[BlogController::class,'destroy'])->name('blog.destroy');

Route::put('blog/{id}',[BlogController::class,'update'])->name('blog.update');