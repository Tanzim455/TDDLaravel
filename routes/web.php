<?php

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

Route::get('blog',function(){
    $posts=Blog::all();
    return view('blogs.index',compact('posts'));
});

Route::get('blog/{id}', function($id){
    $blog = Blog::findOrFail($id);
    return view('blogs.show',['blog'=>$blog]);
});
