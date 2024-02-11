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
    public function test_user_can_publish_a_post(){
         $this->withoutExceptionHandling();
        $blog = Blog::factory()->create(); 
        
        $response = $this->patch(route('blog.update', $blog->id), [
            'published_at'=>Carbon::now()
        ]);
        
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');
        
       
        $this->assertNotNull($blog->fresh()->published_at,);
    }
    public function test_user_can_unpublish_a_post(){
        $this->withoutExceptionHandling();
       $blog = Blog::factory()->create(); 
       
       $response = $this->patch(route('blog.update', $blog->id), [
           'published_at'=>Carbon::now()
       ]);
       $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');
       $responsetwo = $this->patch(route('blog.update', $blog->id), [
        'published_at'=>null
    ]);
    $responsetwo->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');

    $this->assertNull($blog->fresh()->published_at);

    
        
       
      
    //    $this->assertNotNull($blog->fresh()->published_at,);
   }
}
