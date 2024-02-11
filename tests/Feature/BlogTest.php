<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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
    
    public function test_user_can_not_see_unpublished_post(){
        $blog =Blog::factory()->create(); 

        $response=$this->get('/blog');

        $response->assertOk();

        $response->assertDontSee($blog->title);
    }
    public function test_user_can_see_only_published_post()
{
    // Create a blog post with a published date (using the factory)
    // $blog = Blog::factory([
    //     'published_at' => Carbon::now(),
    // ])->create();
   
    // // Make an HTTP request to the '/blog' route
    // $response = $this->get('/blog');
    $blog =Blog::factory()->create(); 
     $this->patch(route('blog.update', $blog->id), [
        'published_at'=>Carbon::now()
    ]);
    
   
    $response=$this->get('/blog');
     $response->assertSee($blog->fresh()->title);
}

    // public function test_user_can_see_a_single_blog(){
    //      //$this->withExceptionHandling();
    //     $blog =Blog::factory()->create(); 
    //     // $this->assertSame('Single blog',$blog->title);
    //     $this->assertEquals(1,Blog::count());
         
    //     $response = $this->get('/blog/'.$blog->id);
    //     $response->assertSee($blog->title);
    //     $response->assertOk(); 
    // }
    public function test_title_field_is_required(){
          $this->withExceptionHandling();
        $response=$this->post(route('blog.store'),[
            'title' =>''
        ]);
        
        
        
         $response->assertSessionHasErrors('title');
        
        
    }
    public function test_user_can_create_a_post(){
        $blog = Blog::factory()->make()->toArray(); 
        // dd($blog);
        $response = $this->post(route('blog.store'),$blog);
    
        $response->assertRedirect(route('blog.index'))->assertSessionHas('message', 'Your blog has been posted');
        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, Blog::count());
        $this->assertDatabaseHas('blogs', $blog);
    }
    
   
    public function test_user_can_update_a_post(){
        // $this->withoutExceptionHandling();
        $blog = Blog::factory()->create(); 
        
        $response = $this->patch(route('blog.update', $blog->id), [
            'title'=>'Title Updated'
        ]);
        
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been updated');
        
        $this->assertDatabaseHas('blogs', [
            
             'title'=>$blog->fresh()->title,
           
            

        ]);
    }
    public function test_edit_route_returns_a_view(){
        $blog =Blog::factory()->create(); 
          $this->get(route('blog.edit',$blog->id))
          ->assertViewIs('blogs.edit')
          ->assertViewHas('blog')
          ->assertSee($blog->title)
          ->assertOk();
    }

    public function test_user_can_delete_a_post(){
        $blog =Blog::factory()->create(); 
        $response=$this->delete(route('blog.destroy',$blog->id));
        $this->assertEquals(0,Blog::count());
        $response->assertRedirectToRoute('blog.index')->assertSessionHas('message', 'Your blog has been deleted');
        $this->assertDatabaseMissing('blogs',[
            'title'=>$blog->title
        ]);
    }
    
}
