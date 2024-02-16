<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogImageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_can_publish_a_image(){
        $this->withoutExceptionHandling();
        $blog = Blog::factory()->make()->toArray(); 
        
        $response = $this->post(route('blog.store'),$blog);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('blogs',[
            'blog_image'=>$blog['blog_image']
        ]);
         
        
          

    
    }
}
