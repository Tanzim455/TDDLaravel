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

        // Create a new blog entry and check if it's displayed on the page
        // Assuming you are using model factories
        //   $this->assertCount(1,Blog::count());
        //  $response->assertSame($blog->title);
         $response->assertSee($blog->title); // Assert that the title of the created blog is present on the page
        $this->assertSame(2,$blog->title);
        // $this->assertCount(1,Blog::count());
        // Check if the blog entry is stored in the database
        // $this->assertEquals(1, Blog::count()); // Ensure that there is one blog entry in the database
    }

    public function test_user_can_see_a_single_blog(){
        // $this->withExceptionHandling();
        $blog = Blog::create(['title' =>'Single blog']); 
        $this->assertSame('Single blog',$blog->title);
        $this->assertEquals(1,Blog::count());
         $this->assertCount(1,Blog::all());
        $response = $this->get('/blog/'.$blog->id);
        $response->assertSee($blog->title);
        $response->assertOk(); 
    }

    public function test_user_can_create_a_post(){
        // $this->withExceptionHandling();
        $response=$this->post(route('blog.store'),[
            'title' =>'Single blog'
        ]);
        
        //  $response->assertOk();
        //  $response->assertRedirectToRoute('blog.index');
        //  $response->assertSessionHas('message','Your blog has been posted');
         $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been posted');

        $this->assertEquals(1,Blog::count());
        $this->assertDatabaseHas('blogs',[
            'title' =>'Single blog'
        ]);
        
    }

    public function test_user_can_delete_a_post(){
        $blog = Blog::create(['title' =>'Single blog']); 
        $response=$this->delete(route('blog.destroy',$blog->id));
        $this->assertEquals(0,Blog::count());
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been posted');
        $this->assertDatabaseMissing('blogs',[
            'title'=>$blog->title
        ]);
    }
    
}
