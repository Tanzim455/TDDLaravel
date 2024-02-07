<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(){
        $posts=Blog::all();
        return view('blogs.index',compact('posts'));
    }

    
        public function show($id){
            $blog = Blog::findOrFail($id);
            return view('blogs.show',['blog'=>$blog]);
        }

        public function store(Request $request){
            Blog::create($request->all());

            return to_route('blog.index')->with('message','Your blog has been posted');
        }
    
}
