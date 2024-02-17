<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //
    public function index(){
        $posts=Blog::published()->get();
        return view('blogs.index',compact('posts'));
    }

    
        public function show(Blog $blog){
            $singleblog = Blog::published()->findOrFail($blog->id);
            return view('blogs.show',['blog'=>$singleblog]);
        }

        public function store(Request $request){
            $validatedData = $request->validate([
                'title' => 'required',
                'body' =>'required',
                 'blog_image'=>''
                 
            ]);
            
           $blog=Blog::create($validatedData);
           if ($request->hasFile('blog_image')) {
            $file = $request->file('blog_image');
            $fileName = $file->getClientOriginalName(); // This will get the original name of the file
             Storage::disk('local')->put('photos/' . $fileName, file_get_contents($file));
            // Storage::disk('local')->put($fileName, file_get_contents($file));
            $blog->update([
                'blog_image' => $fileName
            ]);
        }
        
         
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
