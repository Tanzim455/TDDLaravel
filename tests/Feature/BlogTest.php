<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }
    // use RefreshDatabase;
    public function test_app_has_a_blog_route(): void
    {
        
        $blog = Blog::create(['title' => 2]); 
        // Check if the route '/blog' exists and returns a valid response
        $response = $this->get('/blog');
        $response->assertOk(); // Ensure that the response status code is 200 OK

       
        $this->assertSame(2,$blog->title);
        
    }

    public function test_user_can_see_a_single_blog(){
        // $this->withExceptionHandling();
        $blog = Blog::create(['title' =>'Single blog']); 
        $this->assertSame('Single blog',$blog->title);
        $this->assertEquals(1,Blog::count());
         
        $response = $this->get('/blog/'.$blog->id);
        $response->assertSee($blog->title);
        $response->assertOk(); 
    }

    public function test_user_can_create_a_post(){
        // $this->withExceptionHandling();
        $response=$this->post(route('blog.store'),[
            'title' =>'Single blog'
        ]);
        
        
         $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been posted');

        $this->assertEquals(1,Blog::count());
        $this->assertDatabaseHas('blogs',[
            'title' =>'Single blog'
        ]);
        
    }
    public function test_user_can_update_a_post(){
        $blog = Blog::create(['title' =>'Single blog']); 
        $response = $this->put(route('blog.update', $blog->id), [
            'title' => 'Title Updated'
        ]);
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');
        $this->assertDatabaseHas('blogs', [
            'title' => 'Title Updated'
        ]);
    }
    public function test_edit_route_returns_a_view(){
        $blog = Blog::create(['title' =>'Single blog']); 
          $this->get(route('blog.edit',$blog->id))
          ->assertViewIs('blogs.edit')
          ->assertViewHas('blog')
          ->assertOk();
    }

    public function test_user_can_delete_a_post(){
        $blog = Blog::create(['title' =>'Single blog']); 
        $response=$this->delete(route('blog.destroy',$blog->id));
        $this->assertEquals(0,Blog::count());
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been deleted');
        $this->assertDatabaseMissing('blogs',[
            'title'=>$blog->title
        ]);
    }
    
}
