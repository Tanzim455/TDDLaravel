<?php

namespace Tests\Feature;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPublishTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_can_update_a_post(){
        // $this->withoutExceptionHandling();
        $blog = Blog::factory()->create(); 
        
        $response = $this->put(route('blog.update', $blog->id), [
            'title'=>'Title Updated'
        ]);
        // $updatedBlogTitle=Blog::findOrFail($blog->id);
        //or you can also do 
        $updatedBlogTitle=Blog::where('id',$blog->id)->first();
        
        // dd($updatedBlogTitle["title"]);
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');
        
        $this->assertDatabaseHas('blogs', [
            // 'title' =>$updatedBlogTitle->title,
            //You can also do 
            // 'title'=>$blog->fresh()->title,
            //or you can do 
            'title'=>$updatedBlogTitle["title"]

        ]);
    }
}
