<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(){
        $posts=Blog::published()->get();
        return view('blogs.index',compact('posts'));
    }

    
        public function show(Blog $blog){
            // $blog = Blog::findOrFail($id);
            return view('blogs.show',['blog'=>$blog]);
        }

        public function store(Request $request){
            $validatedData = $request->validate([
                'title' => 'required'
            ]);
        
            Blog::create($validatedData);

            return to_route('blog.index')->with('message','Your blog has been posted');
        }
        public function edit(Blog $blog){
           
            return view('blogs.edit',['blog'=>$blog]);
        }
        public function update(Request $request,Blog $blog){
            
            $blog->update($request->all());
            return redirect()->route('blog.index')->with('message', 'Your blog has been updated');
        }
        
        public function destroy(Blog $blog){
            
            $blog->delete();

            return to_route('blog.index')->with('message','Your blog has been deleted');
        }
}
